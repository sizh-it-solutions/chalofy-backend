<?php

namespace App\Strategies;

use App\Models\{GeneralSetting};
use App\Http\Controllers\Traits\{PaymentStatusUpdaterTrait, MiscellaneousTrait, UserWalletTrait};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PhonePeStrategy implements PaymentStrategy
{
    use PaymentStatusUpdaterTrait, MiscellaneousTrait, UserWalletTrait;

    private $apiURL;
    private $merchantId;
    private $clientId;
    private $clientSecret;
    private $saltKey;
    private $saltIndex;
    private $clientVersion;

    public function __construct()
    {
       

        // live cred
        $this->merchantId = 'M23CWNAT6ZJSK';
        $this->clientId = 'SU2509271650377511604292';
        $this->clientSecret = '649dd11d-a394-40fd-989b-44811391d5e7';
        // $this->saltKey = 1;
        $this->saltIndex = 1;
        $this->clientVersion = 1;

        // //test mode
        // $this->clientId = 'TEST-M23CWNAT6ZJSK_25093';
        // $this->clientSecret = 'ODllNjNkMmQtNDJkMC00ZGU2LTgxZmMtN2YxZjY5MGQ2N2Ni';
        // $this->saltIndex = 1;
        // $this->clientVersion = 1;
    }


    public function process($bookingId, $bookingData, $request)
    {
        

        $accessToken = $this->getAccessToken();

        if (!$accessToken) {

            \Log::error('PhonePe Authentication Failed: No Access Token');

            return redirect('/invalid-order')->with('error', 'Failed to authenticate with PhonePe.');
        }


        $isProduction = true;
        //$isProduction = false;

        $apiURL = $isProduction
            ? 'https://api.phonepe.com/apis/pg/checkout/v2/pay'
            : 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay';


        $payload = [
            "merchantOrderId" => 'order_' . $bookingId,
            "amount" => intval($bookingData->amount_to_pay * 100), // amount in paisa
            "expireAfter" => 1200,
            "paymentFlow" => [
                "type" => "PG_CHECKOUT",
                "message" => "Payment for booking ID {$bookingId}",
                "merchantUrls" => [
                    "redirectUrl" => route('handleCallback', ['booking' => $bookingId]),
                ],
            ],
            "callbackUrl" => route('handlePhonepeWebhook'), // Server-to-server notification
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: O-Bearer ' . $accessToken,
        ];

        $postData = json_encode($payload);

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($httpCode == 200) {
            $responseData = json_decode($response, true);

            if (isset($responseData['redirectUrl'])) {
                // Redirect user to PhonePe payment page
                return redirect()->away($responseData['redirectUrl']);
            }
        }

        return redirect('/invalid-order')->with('error', 'Payment initiation failed.');
    }

    private function getAccessToken()
    {
        $isProduction = true;
        // $isProduction = false;

        $url = $isProduction
            ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token'
            : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $formBody = http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'client_version' => 1,
        ]);


        $response = Http::withHeaders($headers)->send('POST', $url, [
            'body' => $formBody,
        ]);


        $responseData = $response->json();
        return $responseData['access_token'] ?? null;
    }





    public function return($bookingId, $request)
    {
        return '/pending?booking=' . $bookingId;
    }


    private function handlePaymentStatus($bookingId, $paymentId, $phonePeResponse)
    {
        $transactionData = new \stdClass();
        $transactionData->response_data = json_encode($phonePeResponse);
        $transactionData->gateway_name = 'phonepe';
        $transactionData->payment_status = 'completed';
        $transactionData->transaction_id = $paymentId;

        $saveStatus = $this->updateBookingStatus($bookingId, $transactionData);
        $saveStatusData = json_decode($saveStatus, true);

        if ($saveStatusData['status'] === 'success') {
            return '/payment_success';
        } else {
            return '/payment_fail';
        }
    }

    public function handleWebhook($bookingId, $transactionId, $phonePeResponse)
    {
        // Log the raw response from PhonePe

        $state = data_get($phonePeResponse, 'payload.state');

        $paymentStatus = match (strtoupper($state)) {
            'COMPLETED' => 'paid',
            'FAILED' => 'failed',
            default => 'pending',
        };

            // Log the interpreted payment status

        $transactionData = new \stdClass();
        $transactionData->response_data = json_encode($phonePeResponse);
        $transactionData->gateway_name = 'phonepe';
        $transactionData->payment_status = $paymentStatus;
        $transactionData->transaction_id = $transactionId;

        $saveStatus = $this->updateBookingStatus($bookingId, $transactionData);
        $saveStatusData = json_decode($saveStatus, true);

            // Log the result of updating booking status

        if ($saveStatusData['status'] === 'success') {
              
            return '/payment_success';
        } else {

            return '/payment_fail';
        }
    }



    public function refund($bookingId, $bookingData)
    {
        // Implement refund logic
    }

    private function makeCurlRequest($url, $postData, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['status' => 'error', 'message' => $error];
        }

        curl_close($ch);

        if ($httpStatus >= 400) {
            return ['status' => 'error', 'message' => "HTTP Error: $httpStatus, Response: $response"];
        }

        return ['status' => 'success', 'data' => $response];
    }

    public function paymentError()
    {
        return view('Front.Fail');
    }

    public function cancel($bookingId, $bookingData)
    {
        return '/payment_methods?booking=' . $bookingId;
    }

    public function callback($bookingId, $request)
    {

        return view('Front.pending', ['bookingId' => $bookingId]);
    }

    public function rechargeWallet($userID, $amount, $currency, $request)
    {
        $userToken = $request->input('userToken');
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return redirect()->route('wallet_recharge_fail', ['userToken' => $userToken])
                ->with('error', 'PhonePe authentication failed.');
        }

        $orderId = 'wallet_' . $userID . '_' . time(); // unique order id
        $apiURL = 'https://api.phonepe.com/apis/pg/checkout/v2/pay'; // use sandbox if needed

        $payload = [
            "merchantOrderId" => $orderId,
            "amount" => intval($amount * 100), // in paisa
            "expireAfter" => 1200,
            "paymentFlow" => [
                "type" => "PG_CHECKOUT",
                "message" => "Recharge Wallet for User {$userID}",
                "merchantUrls" => [
                    "redirectUrl" => route('wallet.handleReturn', ['userId' => $userID, 'amount' => $amount, 'currency' => $currency]),
                ],
            ],
            "callbackUrl" => route('wallet.handlePhonepeWalletWebhook'),
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: O-Bearer ' . $accessToken,
        ];

        $postData = json_encode($payload);

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            $responseData = json_decode($response, true);

            if (isset($responseData['redirectUrl'])) {
                return redirect()->away($responseData['redirectUrl']);
            }
        }

        return redirect()->route('wallet_recharge_fail', ['userToken' => $userToken])
            ->with('error', 'PhonePe payment initiation failed.');
    }

    public function handleWalletWebhook($userID, $transactionId, $phonePeResponse)
    {
        $state = data_get($phonePeResponse, 'payload.state');

        $paymentStatus = match (strtoupper($state)) {
            'COMPLETED' => 'completed',
            'FAILED' => 'failed',
            default => 'pending',
        };

        $transactionData = new \stdClass();
        $transactionData->response_data = json_encode($phonePeResponse);
        $transactionData->gateway_name = 'phonepe';
        $transactionData->payment_status = $paymentStatus;
        $transactionData->transaction_id = $transactionId;


        if ($paymentStatus === 'completed') {
            $amount = data_get($phonePeResponse, 'payload.amount') / 100;

            // Call addToWallet without assigning to $success
            $this->addToWallet($userID, $amount, 'credit', "Wallet Recharge", 'INR');

            \Log::info("Wallet recharge completed for user {$userID}");

            return '/wallet_recharge_success'; // use your route paths here
        } else {
            return '/wallet_recharge_fail';
        }
    }
}
