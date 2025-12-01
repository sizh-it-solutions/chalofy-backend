<?php

namespace App\Http\Controllers\Front\WalletRecharge;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{PaymentStatusUpdaterTrait,MiscellaneousTrait};
use Illuminate\Http\Request;
use App\Strategies\{StripeStrategy, PaypalStrategy, PayduniyaStrategy, MyFatoorahStrategy, PhonePeStrategy};
use App\Models\{Booking, GeneralSetting};

// Import any other strategies as needed
class WalletRechargeController extends Controller
{
    use PaymentStatusUpdaterTrait,MiscellaneousTrait;

    public function handlePayment(Request $request)
    {
        \Log::info('handlePaymenttttt');

         $token = $request->input('token');
         $userid = $this->checkUserByToken($request->userToken);
      
         if (!$userid) {
            return redirect('/invalid-order')->with('error', 'Invalid user');
         }

        
         $method = $request->method;


        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
           return redirect('/invalid-order')->with('error', 'Invalid user');
        }
        $amount = $request->amount;
        $currency =  $request->currency;
        $returnURL = $strategy->rechargeWallet($userid, $amount, $currency, $request);
        return $returnURL;
    }



    public function handleReturn_bkp(Request $request)
    {
        \Log::info('Return Method Called in handleReturn ', ['request_data' => $request->all()]);
        $bookingId = $request->input('booking');
        $method = $request->input('method');

        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }

        // Handle the return process
        $returnURL = $strategy->return($bookingId, $request->all());
        return redirect($returnURL);

    }

    public function handleReturn(Request $request)
    {
        \Log::info('Wallet redirect PhonePe return Received for Wallet Recharge', [
            'full_request' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        $userId = $request->input('userId');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        \Log::info('Extracted data from request', compact('userId', 'amount', 'currency'));

        if (!$userId || !$amount || !$currency) {
            \Log::error('handleReturn: Missing required parameters');
            return redirect('/payment_fail')->with('error', 'Invalid wallet recharge request');
        }

        \Log::info('Redirecting to wallet_recharge_pending route', ['userID' => $userId]);

        return redirect()->route('wallet_recharge_pending', [
            'userID' => $userId,
            'amount' => $amount,
            'currency' => $currency,
        ]);
    }

    public function handlePhonepeWalletWebhook(Request $request)
    {
        \Log::info('Wallet front PhonePe Wallet Webhook Received', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'raw' => $request->getContent(),
        ]);

        $merchantOrderId = $request->input('payload.merchantOrderId');
        $state = $request->input('payload.state');
        $transactionId = $request->input('payload.paymentDetails.0.transactionId');

        if (!$merchantOrderId) {
            return response()->json(['error' => 'Missing order ID'], 400);
        }

        $parts = explode('_', $merchantOrderId);
        if (count($parts) < 3) {
            return response()->json(['error' => 'Invalid order ID format'], 400);
        }

        $userID = $parts[1]; // user ID
        $strategy = $this->getPaymentStrategy('phonepe');

        if ($strategy && method_exists($strategy, 'handleWebhook')) {
            $redirectUrl = $strategy->handleWalletWebhook($userID, $transactionId, $request->all());

            return redirect($redirectUrl);
        }

        return redirect()->route('wallet_recharge_fail')
            ->with('error', 'Invalid strategy');
    }

    public function handleCallback(Request $request)
    {
        $bookingId = $request->input('booking');
        $method = $request->input('method');
        // $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/newfilesana.txt", "w") or die ("Unable to open file!");
        // $txt = "John Doe\n";
        // fwrite($myfile, $txt);
        // $txt = "Jane Doe\n";
        // fwrite($myfile, $txt);
        // fclose($myfile);
        $strategy = $this->getPaymentStrategy($method);


        if (!$strategy) {
            return response()->json(['error' => 'Invalid payment method'], 400);
        }

        // Handle the callback process
        $strategy->callback($bookingId, $request->all());
        return response()->json(['message' => 'Callback processed'], 200);
    }


    public function handleCancel(Request $request)
    {
        $bookingId = $request->input('booking');
        $method = $request->input('method');

        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }

        $returnURL = $strategy->cancel($bookingId, $request->all());
        return redirect($returnURL);
    }

    protected function getPaymentStrategy($method)
    {
        switch ($method) {
            case 'paypal':
                return new PaypalStrategy();
            case 'stripe':
                return new StripeStrategy();
            case 'payduniya':
                return new PayduniyaStrategy();
            case 'myfatoorah':
                return new MyFatoorahStrategy();
            case 'phonepe':
                return new PhonePeStrategy();

            default:
                return null;
        }
    }

    public function showPaymentPage(Request $request)
    {

        \Log::info('showPaymentPage');

        $bookingId = $request->booking;
        $userToken = $request->token;

        $keys = [
            'stripe_status',
            'paypal_status',
            'paydunya_status',
            'myfatoorah_status'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');
        $stripe_status = $settings->get('stripe_status') ?? null;
        $paypal_status = $settings->get('paypal_status') ?? null;
        $paydunya_status = $settings->get('paydunya_status') ?? null;
        $myfatoorah_status = $settings->get('myfatoorah_status') ?? null;
        
        if($stripe_status->meta_value == 'Active'){
            $status_stripe = true;
        }
        else{
            $status_stripe = false;
        }
        
        if($paypal_status->meta_value == 'Active'){
            $status_paypal = true;
        }
        else{
            $status_paypal = false;
        }
        
        if($paydunya_status->meta_value == 'Active'){
            $status_payduniya = true;
        }
        else{
            $status_payduniya = false;
        }
        if($myfatoorah_status->meta_value == 'Active'){
            $status_myfatoorah = true;
        }
        else{
            $status_myfatoorah = false;
        }

        $phonepe_status = true;

        $paymentMethods = [
            'stripe' => [
                'active' => $status_stripe, // or false
                'route' => '#', // Since Stripe uses JavaScript, we use a placeholder
                'image' => '/front/paymentLogo/Stripe.png',
                'id' => 'stripe-link',
                'form' => false // Stripe doesn't use a form
            ],
            'paypal' => [
                'active' => $status_paypal, // or false
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'paypal']),
                'image' => '/front/paymentLogo/Paypal.png',
                'id' => 'paypal-form',
                'form' => true
            ],
            'payduniya' => [
                'active' => $status_payduniya, // or false
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'payduniya']),
                'image' => '/front/paymentLogo/Payduniya.png',
                'id' => 'payduniya-form',
                'form' => true
            ],
            'myfatoorah' => [
                'active' => $status_myfatoorah, // or false
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'myfatoorah']),
                'image' => '/front/paymentLogo/my-fatoorah.png',
                'id' => 'myfatoorah-form',
                'form' => true
            ],
            'phonepe' => [
                'active' => $phonepe_status,
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'phonepe']),
                'image' => '/front/images/PhonePe.png',
                'id' => 'phonepe-form',
                'form' => true
            ],
        ];
    

        return view('front.payment', compact('bookingId','userToken','paymentMethods'));
    }
    public function paymentSuccess(Request $request)
    {
        $usertoken = $request->usertoken;
        return view('front.WalletRecharge.Success', compact('usertoken'));
    }
    public function paymentFail(Request $request)
    {
        $usertoken = $request->usertoken;
        return view('front.WalletRecharge.Fail', compact('usertoken'));
    }

    public function handlePaypalIPN(Request $request)
{
    // Get the IPN data from the request
    $ipnData = $request->all();

    // Verify the IPN data by sending it back to PayPal
    $verify = $this->verifyPaypalIPN($ipnData);

    // $filename = 'ipn_' . date('Y-m-d_H-i-s') . '.txt';
    // $content = json_encode($ipnData, JSON_PRETTY_PRINT);
    // file_put_contents(storage_path('app/ipn/' . $filename), $content);

    if ($verify) {
        // IPN is verified, process the payment
        $this->processPaypalPayment($ipnData);
    } else {
        // IPN verification failed, log the error
       
    }
}

private function verifyPaypalIPN($ipnData)
{
    // Set the PayPal IPN verification URL
    $verifyURL = 'https://www.paypal.com/cgi-bin/webscr';

        $paypalMode =      $this->getGeneralSettingValue('paypal_options');
    if ($paypalMode === 'test') {
        $verifyURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }

    // Add the '_notify-validate' parameter to the IPN data
    $ipnData['cmd'] = '_notify-validate';

    // Send the IPN data back to PayPal for verification
    $response = Http::asForm()->post($verifyURL, $ipnData);

    // Check the response from PayPal
    return $response->body() === 'VERIFIED';
}

private function processPaypalPayment($ipnData)
{
    // Extract the relevant information from the IPN data
    $transactionType = $ipnData['txn_type'];
    $paymentStatus = $ipnData['payment_status'];
    $paymentAmount = $ipnData['mc_gross'];
    $paymentCurrency = $ipnData['mc_currency'];
    $txnId = $ipnData['txn_id'];
    $receiverEmail = $ipnData['receiver_email'];
    $payerEmail = $ipnData['payer_email'];
    $bookingId = $ipnData['custom'];

    // $filename = 'ipn_' . date('Y-m-d_H-i-s') . '.txt';
    // $content = json_encode($ipnData, JSON_PRETTY_PRINT);
    // file_put_contents(storage_path('app/ipn/' . $filename), $content);

    // Process the payment based on the transaction type and payment status
    if ($transactionType === 'web_accept') {
        if ($paymentStatus === 'Completed') {
            // Payment is completed
            $booking = Booking::findOrFail($bookingId);

            $transactionData = new \stdClass();
            $transactionData->response_data = json_encode($ipnData);
            $transactionData->gateway_name = 'paypal';
            $transactionData->payment_status = 'completed';
            $transactionData->transaction_id = $txnId;

            if ($booking->payment_status !== 'completed') {
                $this->updateBookingStatus($bookingId, $transactionData);
            }
        } elseif ($paymentStatus === 'Pending') {
            // Payment is pending
            $booking = Booking::findOrFail($bookingId);

            if ($booking->payment_status !== 'pending') {

            $transactionData = new \stdClass();
            $transactionData->response_data = json_encode($ipnData);
            $transactionData->gateway_name = 'paypal';
            $transactionData->payment_status = 'pending';
            $transactionData->transaction_id = $txnId;
            $this->updateBookingStatus($bookingId, $transactionData);
            }
        }
    } elseif ($transactionType === 'subscr_payment') {
       
    } elseif ($transactionType === 'subscr_cancel' || $transactionType === 'subscr_eot') {
       
    } elseif ($transactionType === 'recurring_payment') {
        // Recurring payment
        // Handle recurring payment logic here
        // ...
    }

    // Handle other transaction types and payment statuses as needed
    // ...
}
    // public function payment_payduniya(Request $request)
    // {
    //      $bookingId = $request->booking;
    //     return view('front.payment-process',compact('bookingId'));
    // }
    // public function testing(Request $request)
    // {

    //     return view('front.testing');
    // }


    


}