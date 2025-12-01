<?php

namespace App\Strategies;

use App\Models\GeneralSetting;
use App\Http\Controllers\Traits\{PaymentStatusUpdaterTrait, MiscellaneousTrait};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransbankStrategy implements PaymentStrategy
{
    use PaymentStatusUpdaterTrait, MiscellaneousTrait;

    private $apiKeyId;
    private $apiKeySecret;
    private $endpoint;

    public function __construct()
    {
        $mode = $this->getGeneralSettingValue('transbank_options'); // 'test' or 'live'

        if ($mode === 'live') {
            $this->apiKeyId = $this->getGeneralSettingValue('live_transbank_client_id');
            $this->apiKeySecret = $this->getGeneralSettingValue('live_transbank_secret_key');
            $this->endpoint = 'https://webpay3g.transbank.cl/rswebpaytransaction/api/webpay/v1.3/transactions';
        } else {
            $this->apiKeyId = $this->getGeneralSettingValue('test_transbank_client_id');
            $this->apiKeySecret = $this->getGeneralSettingValue('test_transbank_secret_key');
            $this->endpoint = 'https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.3/transactions';
        }
    }


    public function process($bookingId, $bookingData, $request)
    {

        $payload = [
            "buy_order" => "BOOKING_" . $bookingId,
            "session_id" => "SESSION_" . $bookingId,
            "amount" => intval($bookingData->amount_to_pay),
            "return_url" => route('handleReturn', ['booking' => $bookingId, 'method' => 'transbank'])
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Tbk-Api-Key-Id' => $this->apiKeyId,
            'Tbk-Api-Key-Secret' => $this->apiKeySecret,
        ])->post($this->endpoint, $payload);

        if ($response->successful()) {
            $data = $response->json();
            return view('Front.transbank_redirect', [
                'url' => $data['url'],
                'token' => $data['token'],
            ]);
        } else {
            Log::error('Transbank Init Transaction Failed', $response->json());
            return redirect('/invalid-order')->with('error', 'Unable to initiate payment with Transbank.');
        }
    }

    public function return($bookingId, $requestData)
    {
        $token = $requestData['token_ws'];
        $confirmUrl = $this->endpoint . '/' . $token;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Tbk-Api-Key-Id' => $this->apiKeyId,
            'Tbk-Api-Key-Secret' => $this->apiKeySecret,
        ])->put($confirmUrl);

        if ($response->successful()) {
            $result = $response->json();

            if ($result['status'] === 'AUTHORIZED' && $result['response_code'] === 0) {
                $transactionData = new \stdClass();
                $transactionData->response_data = json_encode($result);
                $transactionData->gateway_name = 'transbank';
                $transactionData->payment_status = 'completed';
                $transactionData->transaction_id = $result['buy_order'];

                $saveStatus = $this->updateBookingStatus($bookingId, $transactionData);
                $saveStatusData = json_decode($saveStatus, true);

                if ($saveStatusData['status'] === 'success') {
                    return '/payment_success';
                } else {
                    return '/payment_fail';
                }
            } else {
                Log::warning('Transbank Payment Not Authorized', $result);
                return '/payment_fail';
            }
        } else {
            Log::error('Transbank Confirmation Failed', $response->json());
            return '/payment_fail';
        }
    }

    public function cancel($bookingId, $bookingData)
    {
        return '/payment_methods?booking=' . $bookingId;
    }

    public function callback($bookingId, $requestData)
    {
        // Transbank does not require separate webhook callbacks for Webpay Plus.
    }

    public function refund($bookingId, $bookingData)
    {
        // Implement refund handling if your workflow supports it.
    }
}
