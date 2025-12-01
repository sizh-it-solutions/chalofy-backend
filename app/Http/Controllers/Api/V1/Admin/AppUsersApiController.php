<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait, OTPTrait, MiscellaneousTrait};
use App\Http\Requests\StoreAppUserRequest;
use App\Http\Requests\UpdateAppUserRequest;
use App\Http\Resources\Admin\AppUserResource;
use Illuminate\Support\Facades\Storage;
use App\Models\{AppUser, Payout, Wallet, Media, GeneralSetting, AppUserMeta};
use Illuminate\Support\Str;
use Gate;
use Validator;
use \Auth;
use \Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class AppUsersApiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait, OTPTrait, MiscellaneousTrait;

    public function index()
    {
        abort_if(Gate::denies('app_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AppUserResource(AppUser::with(['package'])->get());
    }

    public function store(StoreAppUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $appUser = AppUser::create($data);

        if ($request->input('profile_image', false)) {
            $appUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
        }

        return (new AppUserResource($appUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AppUser $appUser)
    {
        abort_if(Gate::denies('app_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AppUserResource($appUser->load(['package']));
    }

    public function update(UpdateAppUserRequest $request, AppUser $appUser)
    {
        $data = $request->all();
        if ($data['password'])
            $data['password'] = Hash::make($data['password']);
        $appUser->update($data);

        if ($request->input('profile_image', false)) {
            if (!$appUser->profile_image || $request->input('profile_image') !== $appUser->profile_image->file_name) {
                if ($appUser->profile_image) {
                    $appUser->profile_image->delete();
                }
                $appUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
            }
        } elseif ($appUser->profile_image) {
            $appUser->profile_image->delete();
        }

        return (new AppUserResource($appUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    ////////////// API ////////////
    public function userRegister(Request $request)
    {
        // try {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'numeric', 'min:9'],
            'email' => ['required', 'email'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_country' => ['required'],
        ]);

        if ($validator->fails()) {

            return $this->errorComputing($validator);
        }
        $email = strtolower($request->email);
        if (AppUser::withTrashed()->where('phone', $request->phone)->where('phone_country', $request->phone_country)->exists() || AppUser::withTrashed()->where('email', $email)->exists()) {
            return $this->errorResponse(409, trans('front.user_alredy_exist'));
        } else {

            $token = Str::random(120);

            $customerData = [
                'phone' => $request->phone,
                'email' => $email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_country' => $request->phone_country,
                'fcm' => $request->fcm,
                'status' => 0,
                'default_country' => $request->default_country,
                'token' => $token,
            ];

            $customer = AppUser::create($customerData);

            $otp = $this->generateOtp($request->phone, $request->phone_country);
            $this->sendAllNotifications(['OTP' => $otp, 'otp_for' => "signup"], $customer->id, 2);

            $valuesArray = $customer->only(['first_name', 'last_name', 'email']);
            $valuesArray['phone'] = $customer->phone_country . $customer->phone;
            $settings = GeneralSetting::whereIn('meta_key', ['general_email'])->get()->keyBy('meta_key');

            $general_email = $settings['general_email']->meta_value ?? null;

            $valuesArray['support_email'] = $general_email;
            $valuesArray['otp_for'] = 'signup';

            $this->sendAllNotifications($valuesArray, $customer->id, 1);

            $customer->update(['otp_value' => $otp]);

            $customer['otp_value'] = GeneralSetting::getMetaValue('auto_fill_otp') ? $otp : '';

            return $this->successResponse(200, trans('front.user_created_successfully'), $customer);
        }

        try {
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function generateOtp($phoneNumber, $countryCode)
    {

        DB::table('app_user_otps')
            ->where('phone', $phoneNumber)
            ->where('country_code', $countryCode)
            ->delete();

        $otp = $this->createOTP();

        $expiresAt = Carbon::now()->addMinutes(10);

        DB::table('app_user_otps')->insert([
            'phone' => $phoneNumber,
            'country_code' => $countryCode,
            'otp_code' => $otp,
            'created_at' => Carbon::now(),
            'expires_at' => $expiresAt
        ]);

        return $otp;
    }


    public function validateOtpFromDB($phoneNumber, $countryCode, $inputOtp)
    {

        $otpRecord = DB::table('app_user_otps')
            ->where('phone', $phoneNumber)
            ->where('country_code', $countryCode)
            ->orderByDesc('created_at')
            ->first();

        if (!$otpRecord) {
            return [
                'status' => 'failed',
                'message' => trans('front.noOTP_recordFound')
            ];
        }

        $currentTime = Carbon::now();
        $expiresAt = Carbon::parse($otpRecord->expires_at);

        if ($currentTime->greaterThanOrEqualTo($expiresAt)) {
            return [
                'status' => 'failed',
                'message' => trans('front.OTPhas_expired')
            ];
        }

        if ($otpRecord->otp_code === $inputOtp) {

            DB::table('app_user_otps')
                ->where('id', $otpRecord->id)
                ->delete();

            return [
                'status' => 'success',
                'message' => trans('front.OTP_varified')
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => trans('front.Incorrect_OTP')
            ];
        }
    }

    public function otpVerification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => ['required', 'numeric', 'min:9'],
                'otp_value' => ['required'],
                'phone_country' => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }


            if (AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->exists()) {
                $resultOtp = $this->validateOtpFromDB($request->phone, $request->phone_country, $request->otp_value);
                if ($resultOtp['status'] === 'success') {

                    $token = Str::random(120);
                    $customer = AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->first();
                    $customer->update(['otp_value' => '0', 'email_verify' => '1', 'phone_verify' => '1', 'status' => '1', 'verified' => '1']);
                    return $this->successResponse(200, trans('front.Login_Sucessfully'), $customer);
                } else {
                    return $this->errorResponse(401, trans('front.Wrong_OTP'));
                }
            } else {
                return $this->errorResponse(404, trans('front.User_not_register'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function userLogout(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'token' => ['required'],
                'id' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }
            if (AppUser::where('token', $request->token)->exists()) {
                AppUser::where('token', $request->token)->update(['token' => '']);
                return $this->successResponse(200, trans('front.Logout_Sucessfully'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function userLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => ['required', 'numeric', 'min:9'],
                'password' => ['required'],
                'phone_country' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }
            $data = [
                'phone' => $request->phone,
                'password' => $request->password,
                'phone_country' => $request->phone_country,

            ];

            if (Auth::guard('appUser')->attempt($data)) {
                $otp = $this->createOTP();
                AppUser::where('phone', $request->phone)->update(['otp_value' => $otp, 'token' => '']);
                $customer = AppUser::where('phone', $request->phone)->first();
                unset($customer['token']);
                return $this->successResponse(200, trans('front.Login_Sucessfully'), $customer);
            } else {
                return $this->errorResponse(401, trans('front.something_wrong'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function userEmailLogin(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $data = [
                'email' => strtolower($request->email),
                'password' => $request->password
            ];

            if (Auth::guard('appUser')->attempt($data)) {
                $customer = AppUser::where('email', $request->email)->first();

                if ($customer->status != 1) {
                    $otp = $this->generateOtp($customer->phone, $customer->phone_country);
                    $this->sendAllNotifications(['OTP' => $otp], $customer->id, 2);
                    $customer['reset_token'] = '';
                    if (GeneralSetting::getMetaValue('auto_fill_otp')) {
                        $customer['reset_token'] = $otp;
                    }
                    return $this->successResponse(403, trans('front.account_inactive'), $customer);
                }

                $token = Str::random(120);
                $customer->update(['token' => $token]);

                $mediaItem = Media::where('model_id', $customer->id)
                    ->where('model_type', 'App\Models\AppUser')
                    ->where('collection_name', 'identity_image')
                    ->first();

                $domain = env('APP_URL');
                $imageUrl = $mediaItem ? asset($domain . '/storage/app/public/' . $mediaItem->id . "/" . $mediaItem->file_name) : '';
                $customer['identity_image'] = $imageUrl;

                $module = $this->getModuleIdOrDefault($request);
                $remainingItems = $this->checkRemainingItems($customer->id, $module);

                if ($remainingItems) {
                    $customer['remaining_items'] = $remainingItems;
                } else {
                    $customer['remaining_items'] = 0;
                }

                $firebaseMeta = $customer->metadata->where('meta_key', 'firebase_auth')->first();
                if (!$firebaseMeta) {

                    $firebasePassword = Str::random(16);
                    $apiKey = 'AIzaSyBrI9JUsS-TMmEx1Fnnq-yDlKIiH9WTWA0';

                    $userFirebase = $this->createFirebaseUser($request->email, $firebasePassword, $apiKey);

                    if (isset($userFirebase['success']) && !$userFirebase['success']) {

                        $result = AppUserMeta::updateOrCreate(
                            [
                                'meta_key' => 'firebase_auth',
                                'user_id' => $customer->id
                            ],
                            [
                                'meta_value' => 0
                            ]
                        );
                        $customer['firebase_auth'] = 0;
                    }

                    if (isset($userFirebase['success']) && $userFirebase['success']) {
                        // User created successfully, update the AppUserMeta
                        $result = AppUserMeta::updateOrCreate(
                            [
                                'meta_key' => 'firebase_auth',
                                'user_id' => $customer->id
                            ],
                            [
                                'meta_value' => 1
                            ]
                        );
                        $customer['firebase_auth'] = 1;
                    }
                } else {
                    $customer['firebase_auth'] = $firebaseMeta->meta_value;
                }
                return $this->successResponse(200, trans('front.Login_Sucessfully'), $customer);
            } else {
                return $this->errorResponse(401, trans('front.user_not_exist'));
            }
            // try {
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'displayName' => 'nullable|string',
            'email' => 'nullable|email',
            'id' => 'required|string',
            'login_type' => 'required|in:google,apple',
            'profile_image' => 'nullable|string',
        ]);


        if (empty($request->input('email'))) {
            $temporaryEmailDomain = "@tempmail.unibooker.com";
            $email = $request->input('id') . $temporaryEmailDomain;
        } else {
            $email = strtolower($request->input('email'));
        }

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        // try {

        $displayName = $request->input('displayName');
        $names = explode(' ', $displayName);
        $firstName = $names[0];
        $lastName = isset($names[1]) ? $names[1] : '';

        $socialId = $request->input('id');
        $photoUrl = $request->input('profile_image');
        $loginType = $request->input('login_type');
        DB::beginTransaction();

        if ($request->input('email')) {
            $user = AppUser::where('email', $email)->withTrashed()->first();

            if (!is_null($user) && $user->trashed()) {
                return $this->addErrorResponse(400, trans('User has been block'), '');
            }
        } elseif ($request->input('id')) {
            $user = AppUser::where('social_id', $request->input('id'))->first();
        }

        if ($user) {
            $customer = $this->generateAccessToken($user->email);
            $userIdForRemainingItems = $user->id;
        } else {

            $newUser = AppUser::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email
            ]);
            $imagePath = null;

            // if (!empty($request->input('profile_image'))) {
            //     $imageData = @file_get_contents($request->input('profile_image'));

            //     if ($imageData !== false) {
            //         $imageName = Str::random(40) . '.jpg';
            //         $imagePath = 'profile_images/' . $imageName;

            //         try {
            //             $image = Image::make($imageData);
            //             Storage::put($imagePath, $image->encode('jpg'));
            //         } catch (\Exception $e) {
            //             Log::error('Error processing profile image: ' . $e->getMessage());
            //             $imagePath = null;
            //         }
            //     } else {
            //         $imagePath = null;
            //     }
            // } else {
            //     $imagePath = null;
            // }

            if (!empty($request->input('profile_image'))) {
                $imageUrl = $request->input('profile_image');

                try {
                    $imageData = @file_get_contents($imageUrl);

                    if ($imageData !== false) {
                        $srcImage = imagecreatefromstring($imageData);

                        if ($srcImage !== false) {
                            $width = imagesx($srcImage);
                            $height = imagesy($srcImage);

                            $newImage = imagecreatetruecolor($width, $height);

                            imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $width, $height, $width, $height);

                            $imageName = \Str::random(40) . '.jpg';
                            $imagePath = 'profile_images/' . $imageName;
                            $tempPath = sys_get_temp_dir() . '/' . $imageName;

                            imagejpeg($newImage, $tempPath, 90);

                            \Storage::put($imagePath, file_get_contents($tempPath));

                            imagedestroy($srcImage);
                            imagedestroy($newImage);
                            @unlink($tempPath);
                        } else {
                            $imagePath = null;
                        }
                    } else {
                        $imagePath = null;
                    }
                } catch (\Exception $e) {
                    $imagePath = null;
                }
            } else {
                $imagePath = null;
            }

            if ($imagePath) {
                $newUser->addMedia(storage_path('app/' . $imagePath))->toMediaCollection('profile_image');
            }
            $newUser->social_id = $socialId;
            $newUser->login_type = $loginType;
            $newUser->save();

            $userIdForRemainingItems = $newUser->id;
            $customer = $this->generateAccessToken($email);
        }
        DB::commit();

        $module = $this->getModuleIdOrDefault($request);
        $remainingItems = $this->checkRemainingItems($userIdForRemainingItems, $module);

        if ($remainingItems) {
            $customer['remaining_items'] = $remainingItems;
        } else {
            $customer['remaining_items'] = 0;
        }

        return $this->successResponse(200, trans('front.Login_Sucessfully'), $customer);
        try {
        } catch (\Exception $e) {
            DB::rollback();

            return $this->addErrorResponse(500, trans('front.ServerError_internal_server_error'), $e->getMessage());
        }
    }

    private function generateAccessToken($email)
    {
        $token = Str::random(120);
        AppUser::where('email', $email)->update([
            'otp_value' => '0',
            'token' => $token,
            'verified' => '1',
        ]);
        $customer = AppUser::where('email', $email)->first();
        return $customer;
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        //    try {

        $user = AppUser::where('email', $request->input('email'))->first();

        if (!$user) {
            return $this->addErrorResponse(400, trans('front.User_not_found'), '');
        }


        $otp = $this->generateOtp($user->phone, $user->phone_country);
        $valuesArray = array('OTP' => $otp, 'otp_for' => "forgot password", 'first_name' => $user->first_name, 'last_name' => $user->last_name);
        $template_id = 3;
        $this->sendAllNotifications($valuesArray, $user->id, $template_id);

        AppUser::where('email', $request->email)->update(['reset_token' => $otp, 'token' => '']);
        $responseData = array();
        $responseData['reset_token'] = '';
        if (GeneralSetting::getMetaValue('auto_fill_otp')) {
            $responseData['reset_token'] = $otp;
        }
        return $this->successResponse(200, trans('front.Password_reset_OTP'), $responseData);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.password_Set_error'), $e->getMessage());
        }
    }



    public function verifyResetToken(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'reset_token' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $user = AppUser::where('email', $request->email)->first();
            if (!$user) {
                return $this->addErrorResponse(400, trans('front.User_not_found'), '');
            }

            if ($user) {
                $resultOtp = $this->validateOtpFromDB($user->phone, $user->phone_country, $request->reset_token);
                if ($resultOtp['status'] === 'success') {
                    return $this->successResponse(200, trans('front.RESET_OTP_Found_YOU_CAN_PROCEED'), [
                        'email' => $request->email,
                        'reset_token' => $request->reset_token
                    ]);
                } else {
                    return $this->errorResponse(401, trans('front.RESET_OTP_ERROR'));
                }
            } else {
                return $this->errorResponse(404, trans('front.User_not_register'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'reset_token' => ['required'],
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            if (AppUser::where('email', $request->email)->exists()) {
                if (AppUser::where('email', $request->email)->where('reset_token', $request->reset_token)->exists()) {

                    AppUser::where('email', $request->email)->update(['password' => Hash::make($request->password),]);
                    return $this->successResponse(200, trans('front.Password_changed_successfully.'), [
                        'email' => $request->email,
                        'reset_token' => $request->reset_token
                    ]);
                } else {
                    return $this->errorResponse(401, trans('front.RESET_OTP_ERROR'));
                }
            } else {
                return $this->errorResponse(404, trans('front.User_not_register'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function sendMobileLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'phone_country' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('phone', $request->input('phone'))->where('phone_country', $request->phone_country)->first();

        if (!$user) {
            return $this->addErrorResponse(400, trans('global.User_not_found'), '');
        }

        $otp = $this->generateOtp($user->phone, $user->phone_country);

        $valuesArray = ['OTP' => $otp, 'otp_for' => "login", 'first_name' => $user->first_name, 'last_name' => $user->last_name];
        $template_id = 2;
        $this->sendAllNotifications($valuesArray, $user->id, $template_id);

        $token = Str::random(120);

        $user->update([
            'reset_token' => $otp,
            'token' => $token,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $responseData = [];
        $responseData['reset_token'] = '';

        $user['reset_token'] = '';

        if (GeneralSetting::getMetaValue('auto_fill_otp')) {
            $user['reset_token'] = $otp;
        }

        return $this->successResponse(200, trans('front.OTP_sent_successfully'), $user);
    }


    public function userMobileLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'numeric', 'min:9'],
            'otp_value' => ['required'],
            'phone_country' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        if (AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->exists()) {
            $resultOtp = $this->validateOtpFromDB($request->phone, $request->phone_country, $request->otp_value);
            if ($resultOtp['status'] === 'success') {

                $token = Str::random(120);
                $customer = AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->first();
                if ($customer->status != 1) {
                    return $this->successResponse(200, trans('global.account_inactive'), $customer);
                }

                $customer->update(['token' => $token]);


                $module = $this->getModuleIdOrDefault($request);
                $remainingItems = $this->checkRemainingItems($customer->id, $module);

                $customer['remaining_items'] = $remainingItems ?? 0;

                $item = Item::where('userid_id', $customer->id)->first();

                if (!$item) {

                    $item = Item::create([
                        'userid_id' => $customer->id,
                    ]);
                }




                if ($item) {
                    $customer['item_id'] = $item->id;
                    $customer['item_type_id'] = $item->item_type_id;

                }
                $docunmentsFields = [
                    'driving_licence_front_status',
                    'driving_licence_back_status',
                    'driver_id_front_status',
                    'driver_id_back_status'
                ];

                $metaStatuses = AppUserMeta::where('user_id', $customer->id)
                    ->whereIn('meta_key', $docunmentsFields)
                    ->pluck('meta_value', 'meta_key');

                $statuses = [];
                foreach ($docunmentsFields as $field) {
                    $statuses[] = $metaStatuses[$field] ?? '';
                }

                if (in_array('rejected', $statuses)) {
                    $finalStatus = 'rejected';
                } elseif (count(array_filter($statuses, fn($s) => $s != 'approved')) > 0) {
                    $finalStatus = 'pending';
                } else {
                    $finalStatus = 'approved';
                }

                //   $customer['verification_document_status'] = $customer->document_verify == 1 ? 'approved' : 'pending';
                $customer['verification_document_status'] = $finalStatus;


                return $this->successResponse(200, trans('global.Login_Sucessfully'), $customer);
            } else {
                return $this->errorResponse(401, trans('global.Wrong_OTP'));
            }
        } else {
            return $this->errorResponse(404, trans('global.User_not_register'));
        }
    }

    public function emailcheck(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        if (AppUser::where('email', $request->email)->exists()) {

            return $this->successResponse(200, trans('front.email_already_exists'), [
                'email' => $request->email
            ]);
        } else {

            return $this->errorResponse(401, trans('front.email_is_not_exists'));
        }
    }

    public function mobilecheck(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'numeric', 'digits_between:9,10'],
            'phone_country' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        if (AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->exists()) {
            return $this->successResponse(200, trans('front.Phone_number_is_avilable'), ['phone' => $request->phone]);
        } else {

            return $this->errorResponse(401, trans('front.phone_number_not_exists.'));
        }
    }
    public function ResendOtp(Request $request)
    {

        // $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/resend_otp.txt", "w") or die("Unable to open file!");

        // $txt = "phone = " . $request->input('phone') . "\n";
        // fwrite($myfile, $txt);
        // $txt = "phone_country = " . $request->input('phone_country') . "\n";
        // fwrite($myfile, $txt);
        // fclose($myfile);

        //   try{

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'numeric'],
            'phone_country' => ['required'],
        ]);


        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $checkdata = AppUser::where('phone', $request->phone)->where('phone_country', $request->phone_country)->first();
        if (empty($checkdata)) {
            $checkdata = DB::table('app_user_otps')->where('phone', $request->phone)->where('country_code', $request->phone_country)->first();
        }

        $first_name = '';
        $last_name = '';

        $user = null;
        if ($request->has('token')) {
            $user = AppUser::where('token', $request->input('token'))->first();
        }
        if (!$user) {
            return $this->addErrorResponse(419, trans('front.token_not_match'), '');
        } else {

            $first_name = $user->first_name;
            $last_name = $user->last_name;
        }



        if ($checkdata) {
            $otp = $this->generateOtp($request->phone, $request->phone_country);
            if (isset($checkdata->first_name)) {
                $first_name = $checkdata->first_name;
            }

            if (isset($checkdata->last_name)) {
                $last_name = $checkdata->last_name;
            }

            $valuesArray = array('OTP' => $otp, 'otp_for' => "resend", 'first_name' => $first_name, 'last_name' => $last_name);
            $template_id = 37;
            $this->sendAllNotifications($valuesArray, $checkdata->id, $template_id);
            $responseData = array();
            $responseData['otp_value'] = '';
            if (GeneralSetting::getMetaValue('auto_fill_otp')) {
                $responseData['otp_value'] = $otp;
            }

            return $this->successResponse(200, trans('front.OTP_sent_successfully'), $responseData);
        } else {
            return $this->errorResponse(409, trans('front.user_record_not_match_44'));
        }
        try {
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }
    public function ResendToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);


        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $checkdata = AppUser::where('email', $request->email)->first();
        if ($checkdata) {
            $otp = $this->generateOtp($checkdata->phone, $checkdata->phone_country);
            $valuesArray = array('OTP' => $otp, 'first_name' => $checkdata->first_name, 'last_name' => $checkdata->last_name);
            $template_id = 37;
            $this->sendAllNotifications($valuesArray, $checkdata->id, $template_id);
            $update_otp = AppUser::where('email', $request->email)->update(['reset_token' => $otp]);
            $responseData = array();
            $responseData['reset_token'] = '';
            if (GeneralSetting::getMetaValue('auto_fill_otp')) {
                $responseData['reset_token'] = $otp;
            }

            return $this->successResponse(200, trans('front.OTP_resent_succesfully'), $responseData);
        } else {
            return $this->errorResponse(409, trans('front.user_record_not_match'));
        }
        try {
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }


    public function ResendTokenEmailChange(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'token' => ['required'],
        ]);


        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $checkdata = AppUser::where('token', $request->input('token'))->first();
        if ($checkdata) {
            $otp = $this->generateOtp($checkdata->phone, $checkdata->phone_country);

            $valuesArray = array('OTP' => $otp, 'first_name' => $checkdata->first_name, 'last_name' => $checkdata->last_name);
            if ($request->input('type') === 'email_reset') {
                $valuesArray['temp_email'] = $request->input('email');
            }
            $template_id = 37;
            $this->sendAllNotifications($valuesArray, $checkdata->id, $template_id);
            $update_otp = AppUser::where('email', $request->email)->update(['reset_token' => $otp]);
            $responseData = array();
            $responseData['reset_token'] = '';
            if (GeneralSetting::getMetaValue('auto_fill_otp')) {
                $responseData['reset_token'] = $otp;
            }

            return $this->successResponse(200, trans('front.OTP_resent_succesfully'), $responseData);
        } else {
            return $this->errorResponse(409, trans('front.user_record_not_match'));
        }
        try {
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }


    public function userValidate(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'token' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }
            if (AppUser::where('token', $request->token)->exists()) {

                return $this->successResponse(200, trans('front.user_exist'));
            } else {
                return $this->errorResponse(401, trans('front.user_not_exist'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => ['required'],
                'old_password' => ['required'],
                'new_password' => ['required'],
                'conf_new_password' => ['required', 'same:new_password'],
            ]);
            if ($request)

                if ($validator->fails()) {
                    return $this->errorComputing($validator);
                }

            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->addErrorResponse(419, trans('front.token_not_match'), '');
            }

            if (!Hash::check($request->input('old_password'), $user->password)) {
                return $this->addErrorResponse(500, trans('front.password_does_not_match'), '');
            }

            if (Hash::check($request->input('new_password'), $user->password)) {
                return $this->addErrorResponse(400, trans('front.new_password_same_as_old'), '');
            }
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            return $this->addSuccessResponse(200, trans('front.password_updated_successfully'), $user);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.something_wrong'), '');
        }
    }

    public function getUserWallet(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->addErrorResponse(419, trans('front.token_not_match'), '');
        }

        try {
            $walletBalance = $this->getUserWalletBalance($user->id);
            return $this->addSuccessResponse(200, trans('front.Wallet_amount'), ['wallet_balance' => $walletBalance]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.user_not_found'), '');
        }
    }

    public function getUserWalletTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        // Fetch pagination parameters
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        try {
            $user = AppUser::where('token', $request->input('token'))->first();
            if (!$user) {
                return $this->addErrorResponse(419, trans('front.token_not_match'), '');
            }


            $WalletTransactionsDetails = Wallet::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->toArray(); // Convert to array
            foreach ($WalletTransactionsDetails as &$transaction1) {
                $transaction1['created_at'] = Carbon::parse($transaction1['created_at'])->format('j M Y');
                $transaction1['updated_at'] = Carbon::parse($transaction1['updated_at'])->format('j M Y');
            }

            $WalletTransactionsDetails = collect($WalletTransactionsDetails);

            $nextOffset = $request->input('offset', 0) + count($WalletTransactionsDetails);
            if (empty($WalletTransactionsDetails)) {
                $nextOffset = -1;
            }

            return $this->addSuccessResponse(200, trans('front.Wallet_amount'), [
                'WalletTransactionsDetails' => $WalletTransactionsDetails,
                'offset' => $nextOffset
            ]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.user_not_found'), '');
        }
    }


    public function getVendorWallet(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->addErrorResponse(419, trans('front.token_not_match'), '');
        }

        // try {

        $walletBalance = formatCurrency($this->getVendorWalletBalance($user->id));
        $pendingToWithdrawl = formatCurrency($this->getTotalWithdrawlForVendor($user->id, 'Pending'));
        $totalWithdrawled = formatCurrency($this->getTotalWithdrawlForVendor($user->id, 'Success'));
        $totalEarning = formatCurrency($this->getTotalEarningsForVendor($user->id));
        $refunded = formatCurrency($this->getTotalRefundForVendor($user->id, ''));
        $incoming_amount = formatCurrency($this->getTotalIncomeForVendor($user->id, ''));


        return $this->addSuccessResponse(200, trans('front.vendor_Wallet_amount'), ['walletBalance' => $walletBalance, 'pendingToWithdrawl' => $pendingToWithdrawl, 'totalWithdrawled' => $totalWithdrawled, 'totalEarning' => $totalEarning, 'refunded' => $refunded, 'incoming_amount' => $incoming_amount]);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.something_wrong'), '');
        }
    }

    public function getVendorWalletTransactions(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'offset' => 'nullable|numeric|min:0',
        ]);
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->addErrorResponse(419, trans('front.token_not_match'), '');
        }

        try {
            $WalletTransactionsDetails = $this->getVendorWalletTransactionsDetails($user->id, $offset, $limit);
            return $this->addSuccessResponse(200, trans('front.vendor_Wallet_amount'), ['WalletTransactionsDetails' => $WalletTransactionsDetails['transactions'], 'offset' => $WalletTransactionsDetails['offset']]);
            // try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.something_wrong'), '');
        }
    }

    // fcmUpdate
    public function fcmUpdate(Request $request)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'fcm' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404, trans('front.user_not_found'), '');
        }
        //save data in AppUserMeta
        $this->storeUserMeta($user->id, 'player_id', $request->input('player_id'));

        $user->update([
            'fcm' => $request->input('fcm'),
            'device_id' => $request->input('device_id'),
        ]);

        return $this->addSuccessResponse(200, trans('front.fcm_updated_successfully'), $user);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500, trans('front.something_wrong'), '');
        }
    }


    public function deleteAccount(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            // Find the user by token
            $user = AppUser::where('token', $request->token)->first();

            if (!$user) {
                return $this->errorResponse(404, trans('front.User_not_found'));
            }
            $token = Str::random(120);
            $user->token = $token;
            $user->save();

            // Delete the user
            $user->forceDelete();

            return $this->successResponse(200, trans('front.user_deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('front.something_wrong'));
        }
    }

    public function insertPayout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->errorResponse(404, trans('front.User_not_found'));
        }

        try {
            $payoutStatus = 'Pending';
            $totalPayoutMoney = Payout::where('vendorid', $user->id)->where('payout_status', $payoutStatus)->sum('amount');
            $vendorWalletMoney = $this->getVendorWalletBalance($user->id);

            $withdrawalAmount = $request->input('amount');


            $withdrawalAmount = $withdrawalAmount + $totalPayoutMoney;


            if ($withdrawalAmount > $vendorWalletMoney) {
                return $this->errorResponse(404, trans('front.did_not_have_sufficient_balance'));
            } else {

                $payout = new Payout();
                $payout->vendorid = $user->id;
                $payout->amount = $request->input('amount');
                $payout->currency = $request->input('currency');
                if ($request->has('module_id')) {
                    $payout->module = $request->input('module_id');
                }
                $payout->payment_method = '';
                $payout->payout_status = 'Pending';
                $payout->save();


                $settings = GeneralSetting::whereIn('meta_key', ['general_email', 'general_default_currency'])
                    ->get()
                    ->keyBy('meta_key');

                $general_email = $settings['general_email'] ?? null;
                $general_default_currency = $settings['general_default_currency'] ?? null;

                $template_id = 4;
                $valuesArray = $user->toArray();
                $valuesArray = $user->only(['first_name', 'last_name', 'email', 'phone_country', 'phone']);
                $valuesArray['phone'] = $valuesArray['phone_country'] . $valuesArray['phone'];
                $valuesArray['payout_amount'] = $request->input('amount');
                $valuesArray['payout_bank'] = $payout->payment_method;
                $valuesArray['support_email'] = $general_email->meta_value;
                $valuesArray['currency_code'] = $general_default_currency->meta_value;
                $valuesArray['payout_date'] = now()->format('Y-m-d');
                $this->sendAllNotifications($valuesArray, $user->id, $template_id);

                return $this->successResponse(200, trans('payout requested successfully'), ['payout' => $payout]);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(500, trans('front.something_wrong') . ': ' . $e->getMessage());
        }
    }
    public function getPayoutTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(400, trans('front.something_wrong'));
        }

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        try {
            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->errorResponse(404, trans('front.User_not_found'));
            }

            $payoutTransactions = Payout::where('vendorid', $user->id)
                ->orderByDesc('created_at')
                ->offset($offset)
                ->take($limit)
                ->get()
                ->toArray(); // Convert to array

            foreach ($payoutTransactions as &$transaction) {
                $transaction['created_at'] = Carbon::parse($transaction['created_at'])->format('j M Y');
                $transaction['updated_at'] = Carbon::parse($transaction['updated_at'])->format('j M Y');
            }

            $payoutTransactions = collect($payoutTransactions);

            $nextOffset = $request->input('offset', 0) + count($payoutTransactions);

            if ($payoutTransactions->isEmpty()) {
                $nextOffset = -1;
            }

            return $this->successResponse(200, trans('front.Result_found'), [
                'payout_transactions' => $payoutTransactions,
                'offset' => $nextOffset
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(500, trans('front.something_wrong') . ': ' . $e->getMessage());
        }
    }

    public function emailSmsNotification(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        $type = $request->type;
        $value = $request->value;

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->errorResponse(401, trans('front.user_not_found'));
        }

        if ($type == 'email') {
            $user->update(['email_notification' => $value]);
            return $this->successResponse(200, trans('front.emailNotification'), ['emailNotification' => $user]);
        }
        if ($type == 'push') {
            $user->update(['push_notification' => $value]);
            return $this->successResponse(200, trans('front.pushNotification'), ['emailsmsnotification' => $user]);
        }
        if ($type == 'sms') {
            $user->update(['sms_notification' => $value]);

            return $this->successResponse(200, trans('front.smsNotification'), ['emailsmsnotification' => $user]);
        }
    }

    public function puthostRequest(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'host_status' => 'required',
            'token' => 'required'
        ]);

        $host_status = $request->host_status;
        //$host_status = 1;

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->errorResponse(401, trans('front.user_not_found'));
        }
        $hostFormData = $request->only([
            'host_status',
            'first_name',
            'last_name',
            'company_name',
            'email',
            'phone',
            'country_code',
            'residency_type',
            'full_address',
            'identity_type'
        ]);


        // $userUpdated = $user->update(['host_status' => $host_status]);
        $userUpdated = $user->update([
            'host_status' => $host_status,
            'user_type' => 'vendor',
        ]);
        if ($userUpdated) {


            $imagePath = null;

            if (!empty($request->input('identity_image'))) {
                $identityImage = $request->input('identity_image');
                $identityImageURL = $this->serveBase64Image($identityImage);
                $user->addMedia($identityImageURL)->toMediaCollection('identity_image');
            }

            AppUserMeta::updateOrCreate(
                ['user_id' => $user->id, 'meta_key' => 'host_form_data'],
                ['meta_value' => json_encode($hostFormData)]
            );

            $template_id = 34;
            $valuesArray = $user->toArray();
            $valuesArray = $user->only(['first_name', 'last_name', 'email', 'phone_country', 'phone']);
            $valuesArray['phone'] = $valuesArray['phone_country'] . $valuesArray['phone'];
            $settings = GeneralSetting::whereIn('meta_key', ['general_email'])->get()->keyBy('meta_key');

            // Get the general email value safely
            $general_email = $settings['general_email']->meta_value ?? null;

            // Add support email to the values array
            $valuesArray['support_email'] = $general_email;

            $this->sendAllNotifications($valuesArray, $user->id, $template_id);
        }

        return $this->successResponse(200, trans('front.hostRequest'), ['host_status' => $host_status]);
    }

    public function gethostStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->errorResponse(401, trans('front.user_not_found'));
        }


        return $this->successResponse(200, trans('front.hostRequest'), ['host_status' => $user->host_status]);
    }

    public function saveDoorStepAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->errorResponse(401, trans('front.user_not_found'));
        }

        $addressData = $request->only([
            'house_floor_number',
            'building_block_number',
            'landmark',
            'full_address',
            'city',
            'state',
            'country',
            'postal_code',
            'doorstep_latitude',
            'doorstep_longitude'
        ]);

        AppUserMeta::updateOrCreate(
            ['user_id' => $user->id, 'meta_key' => 'door_step_address'],
            ['meta_value' => json_encode($addressData)]
        );

        return $this->successResponse(200, 'Address Saved');
    }

    public function getDoorStepAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();
        if (!$user) {
            return $this->errorResponse(401, trans('front.user_not_found'));
        }

        $doorStepMeta = AppUserMeta::where('user_id', $user->id)
            ->where('meta_key', 'door_step_address')
            ->first();

        if (!$doorStepMeta || empty($doorStepMeta->meta_value)) {
            return $this->errorResponse(404, 'Doorstep address not found');
        }

        $doorStepAddress = json_decode($doorStepMeta->meta_value, true);

        return $this->successResponse(200, 'Address Found', ['door_step_address' => $doorStepAddress]);
    }
}
