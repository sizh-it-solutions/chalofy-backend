<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{PaymentStatusUpdaterTrait, MiscellaneousTrait};
use Illuminate\Http\Request;
use App\Strategies\{StripeStrategy, PaypalStrategy, PayduniyaStrategy, RazorpayStrategy, OfflineStrategy, TransbankStrategy, PhonePeStrategy};
use App\Models\{Booking, GeneralSetting};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

// Import any other strategies as needed
class PaymentFrontController extends Controller
{
    use PaymentStatusUpdaterTrait, MiscellaneousTrait;

    public function handlePayment(Request $request)
    {
        $bookingId = $request->input('booking');
        $method = $request->input('method');
        $bookingData = Booking::find($bookingId);

        
        if (!$bookingData) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }
        if ($bookingData->payment_status === 'paid') {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }

        $strategy = $this->getPaymentStrategy($method);


        if (!$strategy) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }

        $returnURL = $strategy->process($bookingId, $bookingData, $request);
        return $returnURL;
    }



    public function handleReturnbkkpp(Request $request)
    {


        $bookingId = $request->input('booking');
        $method = $request->input('method');


        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }
        // $returnURL = $strategy->return($bookingId, $request->all());
        $returnURL = $strategy->return($bookingId, $request);
        return redirect($returnURL);

    }

    public function handleRazorpayReturn(Request $request)
    {

        $bookingId = $request->input('booking');
        $method = $request->input('method');

        $strategy = $this->getPaymentStrategy($method);

        if (! $strategy) {
            return redirect('/invalid-order')->with('error', 'Invalid booking ID');
        }
        // $returnURL = $strategy->return($bookingId, $request->all());
        $returnURL = $strategy->return($bookingId, $request);

        return redirect($returnURL);

    }

     public function handleReturn(Request $request)
    {
       // \Log::info("Razorpay Return Details", $request->all());

        $bookingId = $request->input('booking');
        $method = 'phonepe';
        //$method = $request->input('method');
        $strategy = $this->getPaymentStrategy($method);


        if (!$strategy) {
            return redirect('/payment_fail')->with('error', 'Invalid payment method');
        }

        return redirect()->route('payment_pending', ['bookingId' => $bookingId]);
    }

    public function handleCallback_bkp_29_10_2025(Request $request)
    {
        $bookingId = $request->input('booking');
        $method = $request->input('method');
        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
            return response()->json(['error' => 'Invalid payment method'], 400);
        }
        $strategy->callback($bookingId, $request->all());
        return response()->json(['message' => 'Callback processed'], 200);
    }

    public function handleCallback(Request $request)
    {

        $bookingId = $request->input('booking');
        $method = 'phonepe';
        $strategy = $this->getPaymentStrategy($method);

        if (!$strategy) {
            return redirect('/payment_fail')->with('error', 'Invalid payment method');
        }

        return redirect()->route('payment_pending', ['bookingId' => $bookingId]);
    }

    public function handlePhonepeWebhook_bkp_16_02_2025(Request $request)
    {

        $merchantOrderId = $request->input('payload.merchantOrderId');
        $state = $request->input('payload.state');
        $transactionId = $request->input('payload.paymentDetails.0.transactionId');

        if (!$merchantOrderId) {
            return response()->json(['error' => 'Missing order ID'], 400);
        }

        if (Str::startsWith($merchantOrderId, 'wallet_')) {
            // Route to wallet handler
            $walletController = app(\App\Http\Controllers\Front\WalletRecharge\WalletRechargeController::class);
            return $walletController->handlePhonepeWalletWebhook($request);
        }

        // Default: treat as booking
        $bookingId = str_replace('order_', '', $merchantOrderId);
        $strategy = $this->getPaymentStrategy('phonepe');

        if ($strategy && method_exists($strategy, 'handleWebhook')) {
            $redirectUrl = $strategy->handleWebhook($bookingId, $transactionId, $request->all());
            return redirect($redirectUrl);
        }

        return redirect('/payment_fail')->with('error', 'Invalid strategy.');
    }

    public function handlePhonepeWebhook(Request $request)
    {
       

        $merchantOrderId = $request->input('payload.merchantOrderId');
        $state = $request->input('payload.state');
        $transactionId = $request->input('payload.paymentDetails.0.transactionId');

        

        if (!$merchantOrderId) {
            Log::warning('PhonePe Webhook Missing Merchant Order ID', [
                'request_payload' => $request->all()
            ]);
            return response()->json(['error' => 'Missing order ID'], 400);
        }

        // if (Str::startsWith($merchantOrderId, 'wallet_')) {
        //     // Log routing to wallet handler
        //     Log::info('PhonePe Webhook Routed to Wallet Handler', [
        //         'merchant_order_id' => $merchantOrderId
        //     ]);

        //     $walletController = app(\App\Http\Controllers\Front\WalletRecharge\WalletRechargeController::class);
        //     return $walletController->handlePhonepeWalletWebhook($request);
        // }

        // Default: treat as booking
        // $bookingId = str_replace('order_', '', $merchantOrderId);
        $bookingId = str_ireplace('order_', '', $merchantOrderId);


        $strategy = $this->getPaymentStrategy('phonepe');

        if ($strategy && method_exists($strategy, 'handleWebhook')) {
            $redirectUrl = $strategy->handleWebhook($bookingId, $transactionId, $request->all());

            return redirect($redirectUrl);
        }

        return redirect('/payment_fail')->with('error', 'Invalid strategy.');
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
            case 'razorpay':
                return new RazorpayStrategy();
            case 'offline':
                return new OfflineStrategy();
            case 'transbank':
                return new TransbankStrategy();
            case 'phonepe':
                return new PhonePeStrategy();
            default:
                return null;
        }
    }


    public function showPaymentPage(Request $request)
    {

        $bookingId = $request->booking;

        $keys = [
            'stripe_status',
            'paypal_status',
            'paydunya_status',
            'razorpay_status',
            'cash_status',
            'transbank_status'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');
        $stripe_status = $settings->get('stripe_status') ?? null;
        $paypal_status = $settings->get('paypal_status') ?? null;
        $paydunya_status = $settings->get('paydunya_status') ?? null;
        $razorpay_status = $settings->get('razorpay_status') ?? null;
        $cash_status = $settings->get('cash_status') ?? null;

        $stripeMode = $this->getGeneralSettingValue('stripe_options');
        $stripePublicKey = $stripeMode === 'test'
            ? $this->getGeneralSettingValue('test_stripe_public_key')
            : $this->getGeneralSettingValue('live_stripe_public_key');

        $transbank_status = $settings->get('transbank_status') ?? null;
        if ($transbank_status->meta_value == 'Active') {
            $status_transbank = true;
        } else {
            $status_transbank = false;
        }
        if ($stripe_status->meta_value == 'Active') {
            $status_stripe = true;
        } else {
            $status_stripe = false;
        }

        if ($paypal_status->meta_value == 'Active') {
            $status_paypal = true;
        } else {
            $status_paypal = false;
        }

        if ($paydunya_status->meta_value == 'Active') {
            $status_payduniya = true;
        } else {
            $status_payduniya = false;
        }
        if ($razorpay_status->meta_value == 'Active') {
            $razorpay_status = true;
        } else {
            $razorpay_status = false;
        }
        if ($cash_status->meta_value == 'Active') {
            $cash_status = true;
        } else {
            $cash_status = false;
        }

        \Log::info("Before test razorpay flow");
        $phonepe_status = true;
        \Log::info("After test razorpay flow", ['status' => $razorpay_status]);

        $paymentMethods = [
            'cash' => [
                'active' => $cash_status,
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'offline']),
                'image' => '/front/paymentLogo/cash.png',
                'id' => 'offline-form',
                'form' => true
            ],
            'stripe' => [
                'active' => $status_stripe,
                'route' => '#',
                'image' => '/front/paymentLogo/Stripe.png',
                'id' => 'stripe-link',
                'public_key' => $stripePublicKey,
                'form' => false
            ],
            // 'paypal' => [
            //     'active' => $status_paypal,
            //     'route' => route('payment', ['booking' => $bookingId, 'method' => 'paypal']),
            //     'image' => '/front/paymentLogo/Paypal.png',
            //     'id' => 'paypal-form',
            //     'form' => true
            // ],
            // 'payduniya' => [
            //     'active' => $status_payduniya,
            //     'route' => route('payment', ['booking' => $bookingId, 'method' => 'payduniya']),
            //     'image' => '/front/paymentLogo/Payduniya.png',
            //     'id' => 'payduniya-form',
            //     'form' => true
            // ],
            'razorpay' => [
                'active' => $razorpay_status,
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'razorpay']),
                'image' => '/front/images/Razorpay.png',
                'id' => 'razorpay-form',
                'form' => true
            ],
            // 'transbank' => [
            //     'active' => $status_transbank,
            //     'route' => route('payment', ['booking' => $bookingId, 'method' => 'transbank']),
            //     'image' => '/front/paymentLogo/transbank.jpeg',
            //     'id' => 'transbank-form',
            //     'form' => true
            // ],
            'phonepe' => [
                'active' => $phonepe_status,
                'route' => route('payment', ['booking' => $bookingId, 'method' => 'phonepe']),
                'image' => '/front/images/PhonePe.png',
                'id' => 'phonepe-form',
                'form' => true
            ],
        ];

        return view('front.payment', compact('bookingId', 'paymentMethods'));
    }
    public function paymentSuccess(Request $request)
    {
        $bookingId = $request->bookingId;
        return view('front.Success', compact('bookingId'));
    }
    public function paymentFail(Request $request)
    {

        $bookingId = $request->bookingId;

        return view('front.Fail', compact('bookingId'));
    }

    public function paymentPending(Request $request)
    {
        $bookingId = $request->query('bookingId');

        return view('front.pending', compact('bookingId'));
    }


    public function handlePaypalIPN(Request $request)
    {
        $ipnData = $request->all();
        $verify = $this->verifyPaypalIPN($ipnData);

        // $filename = 'ipn_' . date('Y-m-d_H-i-s') . '.txt';
        // $content = json_encode($ipnData, JSON_PRETTY_PRINT);
        // file_put_contents(storage_path('app/ipn/' . $filename), $content);

        if ($verify) {
            $this->processPaypalPayment($ipnData);
        } else {
            Log::error('PayPal IPN verification failed.');
        }
    }

    private function verifyPaypalIPN($ipnData)
    {

        $verifyURL = 'https://www.paypal.com/cgi-bin/webscr';
        $paypalMode = $this->getGeneralSettingValue('paypal_options');
        if ($paypalMode === 'test') {
            $verifyURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        $ipnData['cmd'] = '_notify-validate';
        $response = Http::asForm()->post($verifyURL, $ipnData);
        return $response->body() === 'VERIFIED';
    }

    private function processPaypalPayment($ipnData)
    {
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

     public function getPaymentStatus(Request $request)
    {
        $bookingId = $request->query('bookingId');

        $booking = Booking::where('id', $bookingId)->first();

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json([
            'payment_status' => $booking->payment_status,  // e.g., 'paid', 'pending', 'failed'
            'payment_method' => $booking->payment_method   // e.g., 'phonepe', 'card', etc.
        ]);
    }
}