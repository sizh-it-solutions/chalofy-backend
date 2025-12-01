<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Module, AppUser, GeneralSetting};
use App\Models\Modern\{Item};
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait};

class ChatController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait;
    public function chatPage()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $vendorId = $user->id;
        }
        $settings = GeneralSetting::whereIn('meta_key', [
            'push_notification_status',
            'pushnotification_key',
            'onesignal_app_id',
            'onesignal_rest_api_key'
        ])->get()->pluck('meta_value', 'meta_key')->toArray();

        $onesignalAppId = "";
        if ($settings['push_notification_status'] == 'onesignal') {
            $onesignalAppId = $settings['onesignal_app_id'];
        } 

        return view('vendor.chat.chat',compact('onesignalAppId'));
    
    }

}
