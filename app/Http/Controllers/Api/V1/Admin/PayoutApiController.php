<?php

namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait,UserWalletTrait};
use App\Models\{Booking, AppUser};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PayoutApiController extends Controller
{    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait,UserWalletTrait;

   
    public function getTotalPayoutAmount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:app_users,token',
        ]);
    
        if ($validator->fails()) {
            return $this->addErrorResponse(401,trans('front.invalid_token'), $validator->errors());
        }
    
        $user = AppUser::where('token', $request->input('token'))->first();
    
        if (!$user) {
            return $this->addErrorResponse(401,trans('front.user_not_found'), 'User not found');
        }
    
        $vendorId = $user->id;
     
            $totalPayoutAmount = Booking::where('host_id', $vendorId)
    ->where('status', 'Confirmed')
    ->whereDate('check_out', '<=', now())
    ->with('bookingFinance')
    ->get()
    ->sum(function ($booking) {
        return $booking->bookingFinance->vendor_commission ?? 0;
    });
        return $this->addSuccessResponse(200,trans('front.Result_found'), ['total_payout_amount' => $totalPayoutAmount]);
    }
}
