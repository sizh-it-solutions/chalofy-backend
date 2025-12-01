<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, OTPTrait, EmailTrait, SMSTrait, MiscellaneousTrait, BookingAvailableTrait, NotificationTrait};
use App\Models\{AppUser, AppUsersBankAccount, Booking, GeneralSetting};
use App\Models\Modern\{Item};
use Validator;
use \Hash;
use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, OTPTrait, EmailTrait, SMSTrait, MiscellaneousTrait, BookingAvailableTrait, NotificationTrait;
    public function editProfile(Request $request)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->intro = $request->input('intro', null);
        $user->langauge = $request->input('langauge', null);
        $user->country = $request->input('country', null);
        $user->birthdate = $request->input('birthdate');
        $identity_image = $request->input('identity_image', null);
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($identity_image) {
            $identityImage = $request->input('identity_image');
            $identityImageUrl = $this->serveBase64Image($identityImage, 'app/profile_images/');
            if ($identityImageUrl) {

                if ($user->identity_image) {
                    $user->identity_image->delete();
                }
                $user->addMedia($identityImageUrl)->toMediaCollection('identity_image');
            }
        }

        $user->save();
        $user = AppUser::where('token', $request->input('token'))->first();
        if ($user->identity_image) {
            $user['identity_image'] = $user->identity_image->url;
        } else {
            $user['identity_image'] = null;
        }

        return $this->addSuccessResponse(200,trans('front.update_profile_success'), ['user' => $user]);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function checkMobileNumber(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'phone' => 'required|min:8|max:12',
            'phone_country' => 'required',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        // try {
        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $existingUser = AppUser::where('phone', '=', trim($request->input('phone')))
            ->where('phone_country', '=', trim($request->input('phone_country')))
            ->where('id', '!=', $user->id)
            ->withTrashed()
            ->first();

        if ($existingUser) {
            return $this->addErrorResponse(400,trans('front.mobile_number_already_exists'), '');
        }

        if ($user->phone == $request->input('phone') && $user->phone_country == $request->input('phone_country')) {
            return $this->addErrorResponse(400,trans('front.mobile_number_same_as_current'), '');
        }


        // For email  
        if (!empty($request->input('email'))) {
            $existingEmailUser = AppUser::where('email', $request->input('email'))
                ->where('id', '!=', $user->id)
                ->withTrashed()
                ->first();

            if ($existingEmailUser) {
                return $this->addErrorResponse(400,trans('front.email_already_exists'), '');
            }
        }


        $otp = $this->generateOtp($request->phone, $request->phone_country);
        $responseData = [
            'phone' => $request->input('phone'),
            'phone_country' => $request->input('phone_country'),
            'otp' => '',
        ];

        $valuesArray = array('OTP' => $otp, 'temp_phone' =>  $request->input('phone_country') . $request->input('phone'));
        $this->sendAllNotifications($valuesArray, $user->id, 38);
        $responseData['otp'] = GeneralSetting::getMetaValue('auto_fill_otp') ? $otp : '';

        return $this->addSuccessResponse(200,trans('front.mobile_availabel_move_OTP_screen'), $responseData);

        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }



    public function checkEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }
        $existingUser = AppUser::where('email', $request->input('email'))
            ->where('id', '!=', $user->id)
            ->withTrashed()
            ->first();

        if ($existingUser) {
            return $this->addErrorResponse(400,trans('front.email_already_exists'), '');
        }
        if ($user->email == $request->input('email')) {
            return $this->addErrorResponse(400,trans('front.email_same_as_current'), '');
        }
        $otp = $this->generateOtp($user->phone, $user->phone_country);
        $responseData = [
            'email' => $request->input('email')
        ];
        $valuesArray = array('OTP' => $otp, 'temp_email' => $request->input('email'));
        $this->sendAllNotifications($valuesArray, $user->id, 36);
        $responseData['otp'] = GeneralSetting::getMetaValue('auto_fill_otp') ? $otp : '';
        return $this->addSuccessResponse(200,trans('front.email_available_move_OTP_screen'), $responseData);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }



    public function changeMobileNumber(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'phone' => 'required|min:8|max:12',
            'phone_country' => 'required',
            'otp_value' => 'required',
            'default_country' => 'nullable|string',
            'email' => 'nullable|email',

        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        if ($user->phone == $request->input('phone') && $user->phone_country == $request->input('phone_country')) {
            return $this->addErrorResponse(400,trans('front.mobile_number_same_as_current'), '');
        }

        $resultOtp = $this->validateOtpFromDB($request->phone, $request->phone_country, $request->otp_value);
        if ($resultOtp['status'] === 'success') {
            $user->phone = $request->input('phone');
            $user->phone_country = $request->input('phone_country');
            $user->default_country = $request->input('default_country');
            $user->phone_verify = 1;

            if (!empty($request->input('email'))) {
                $user->email = $request->input('email');
            }
            if (!empty($request->input('first_name'))) {
                $user->first_name = $request->input('first_name');
            }
            if (!empty($request->input('last_name'))) {
                $user->last_name = $request->input('last_name');
            }

            $user->save();
            $userdata = AppUser::where('token', $request->input('token'))->first();
            return $this->addSuccessResponse(200,trans('front.mobile_number_updated_successfully'), $userdata);
        } else {
            return $this->errorResponse(401,trans('front.Wrong_OTP'));
        }
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }




    public function changeEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|unique:users,email',
            'otp_value' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        if ($user->email == $request->input('new_email')) {
            return $this->addErrorResponse(400,trans('front.email_same_as_current'), '');
        }
        $resultOtp = $this->validateOtpFromDB($user->phone, $user->phone_country, $request->otp_value);
        if ($resultOtp['status'] === 'success') {
            $user->email = $request->input('email');
            $user->email_verify = 1;
            $user->save();
            $userdata = AppUser::where('token', $request->input('token'))->first();
            return $this->addSuccessResponse(200,trans('front.email_updated_successfully'), $userdata);
        } else {
            return $this->errorResponse(401,trans('front.Wrong_OTP'));
        }
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }


    protected function validateBase64Image($attribute, $value, $parameters, $validator)
    {
        $decoded = base64_decode($value);
        $data = getimagesizefromstring($decoded);

        return $data !== false && in_array($data[2], [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF]);
    }

    public function uploadProfileImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'profile_image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        if ($request->has('profile_image')) {
            $profileImage = $request->input('profile_image');

            $frontImageUrl = $this->serveBase64Image($profileImage, 'app/profile_images/');
            if ($frontImageUrl) {
                if ($user->profile_image) {
                    $user->profile_image->delete();
                }
                $user->addMedia($frontImageUrl)->toMediaCollection('profile_image');
                $user = AppUser::where('token', $request->input('token'))->first();
                return $this->addSuccessResponse(200,trans('front.profile_image_successfully'), ['profile_image_url' => $user->profile_image->url]);
            } else {
                return $this->addErrorResponse(500,trans('front.Failed_to_upload_image'), '');
            }
        } else {
            return $this->addErrorResponse(500,trans('front.No_image_found_in_the_request'), '');
        }
    }

    public function insertBankAccount(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'account_name' => 'required|string',
                'bank_name' => 'required|string',
                'branch_name' => 'nullable|string',
                'account_number' => 'required|string',
                'iban' => 'nullable|string',
                'swift_code' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->addErrorResponse(404,trans('front.user_not_found'), '');
            }

            $bankAccount = AppUsersBankAccount::firstOrNew(['user_id' => $user->id]);
            $bankAccount->fill($validator->validated());
            $bankAccount->save();

            $message = $bankAccount->wasRecentlyCreated ?trans('front.bank_account_created_successfully') :trans('front.bank_account_updated_successfully');

            return $this->addSuccessResponse(200, $message, ['data' => $bankAccount]);
        } catch (\Exception $e) {

            return $this->addErrorResponse(500,trans('front.something_wrong'), []);
        }
    }

    public function getBankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $bankAccount = AppUsersBankAccount::where('user_id', $user->id)->first();

        if (!$bankAccount) {
            return $this->addErrorResponse(200,trans('front.bank_account_not_found'), ['data' => $bankAccount]);
        }


        return $this->addSuccessResponse(200,trans('front.bank_account_retrieved_successfully'), ['data' => $bankAccount]);
    }

    public function getUserDashboardStats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);
        $module = $this->getModuleIdOrDefault($request);
        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $totalSales = Booking::where('host_id', $user->id)
            ->where('module', $module)
            ->where('status', 'Completed')
            ->count();

        $todayOrders = Booking::where('host_id', $user->id)
            ->where('module', $module)
            ->where('payment_status', 'Paid')
            ->whereDate('created_at', today())
            ->count();

        $newProducts = Item::where('userid_id', $user->id)
            ->where('module', $module)
            ->count();

        $pendingOrders = Booking::where('host_id', $user->id)
            ->where('module', $module)
            ->where('status', 'Pending')
            ->where('payment_status', 'Paid')
            ->count();

        $confirmedOrders = Booking::where('host_id', $user->id)
            ->where('module', $module)
            ->where('status', 'Confirmed')
            ->where('payment_status', 'Paid')
            ->count();

        $cancelledOrders = Booking::where('host_id', $user->id)
            ->where('module', $module)
            ->whereIn('status', ['Cancelled', 'Declined'])
            ->where('payment_status', 'Paid')
            ->count();

        $dashboardStats = [
            'total_sales' => $totalSales,
            'today_orders' => $todayOrders,
            'new_products' => $newProducts,
            'pending_orders' => $pendingOrders,
            'confirmedOrders' => $confirmedOrders,
            'cancelledOrders' => $cancelledOrders,
        ];

        return $this->addSuccessResponse(200,trans('front.dashboard_stats_retrieved_successfully'), ['data' => $dashboardStats]);
    }
    public function toggleProductStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'item_id' => 'required|integer',
            'status' => 'required|in:publish,unpublish',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $item = Item::where('id', $request->input('item_id'))
            ->where('userid_id', $user->id)
            ->first();

        if (!$item) {
            return $this->addErrorResponse(404,trans('front.product_not_found'), '');
        }

        $status = $request->input('status');
        if ($status === 'publish') {
            $status = '1';
        } elseif ($status === 'unpublish') {
            $status = '0';
        }
        $item->status = $status;
        $item->save();

        return $this->addSuccessResponse(200,trans('front.product_status_updated_successfully'), [
            'item_id' => $request->input('item_id'),
            'status' => $status
        ]);
    }
}
