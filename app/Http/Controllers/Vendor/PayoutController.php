<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{GeneralSetting, VendorWallet, Booking, AppUser, Payout};
use App\Models\Modern\{Item};
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait};


class PayoutController extends Controller
{


    use MediaUploadingTrait, ResponseTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait;

    public function index()
    {

        if (auth()->check()) {
            $user = auth()->user();
            $vendorId = $user->id;
        }
        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');

        $query = Payout::where('vendorid', $vendorId);

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($status) {
            $query->where('payout_status', $status);
        }

        $payoutTransactions = $query->orderByDesc('created_at')->paginate(50);



        $general_default_currency = GeneralSetting::where('meta_key', 'general_default_currency')->first();

        $hostspendmoney = number_format($this->getVendorWalletBalance($vendorId), 2);
        $hostpendingmoney = number_format($this->getTotalWithdrawlForVendor($vendorId, 'Pending'), 2);
        $hostrecivemoney = number_format($this->getTotalWithdrawlForVendor($vendorId, 'Success'), 2);

        $totalmoney = number_format($this->getTotalEarningsForVendor($vendorId), 2);
        $refunded = number_format($this->getTotalRefundForVendor($vendorId, ''), 2);
        $incoming_amount = number_format($this->getTotalIncomeForVendor($vendorId, ''), 2);
        $module = 2;
        $totalSales = Booking::where('host_id', $vendorId)
            ->where('module', $module)
            ->where('status', 'Completed')
            ->count();

        $todayOrders = Booking::where('host_id', $vendorId)
            ->where('module', $module)
            ->whereDate('created_at', today())
            ->count();

        $allProducts = Item::where('userid_id', $vendorId)
            ->where('module', $module)
            ->count();

        $pendingOrders = Booking::where('host_id', $vendorId)
            ->where('module', $module)
            ->where('status', 'Pending')
            ->count();

        return view('vendor.payouts.index', compact('vendorId', 'hostspendmoney', 'hostpendingmoney', 'hostrecivemoney', 'totalmoney', 'refunded', 'incoming_amount', 'payoutTransactions', 'totalSales', 'todayOrders', 'allProducts', 'pendingOrders', 'general_default_currency'));
    }
    public function requestPayout(Request $request)
    {
        $userId = auth()->user()->id;
        $general_default_currency = GeneralSetting::where('meta_key', 'general_default_currency')->first();
        $appUser = AppUser::where('id', $userId)->first();

        if (!$appUser || !$appUser->token) {
            return response()->json([
                'status' => 400,
                'message' => 'Token not found for the authenticated user.',
            ], 400);
        }

        $data = [
            'amount' => $request->input('amount'),
            'currency' => $general_default_currency->meta_value,
            'token' => $appUser->token,
        ];

        $response = Http::post(url('api/v1/insertPayout'), $data);

        return response()->json($response->json());
    }
}
