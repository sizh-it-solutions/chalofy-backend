<?php
namespace App\Strategies;

use App\Models\{Booking};
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait, UserWalletTrait, VendorWalletTrait, PaymentStatusUpdaterTrait, BookingAvailableTrait};


class OfflineStrategy implements PaymentStrategy
{
    use ResponseTrait, MediaUploadingTrait, MiscellaneousTrait,PaymentStatusUpdaterTrait;

    public function __construct() {}

    public function process($bookingId, $bookingData, $request)
    {

        $bookingData = Booking::find($bookingId);
        $bookingData->payment_status = 'paid';
        $bookingData->payment_method = 'offline';
       
        $bookingData->save();

        $template_id = 14;
        $valuesArray = array();
        $valuesArray =   $this->createNotificationArray($bookingData->userid, $bookingData->host_id, $bookingData->itemid, $bookingData->id);
        $dataVal['message_key'] =  $bookingData;
        $this->sendAllNotifications($valuesArray, $bookingData->userid, $template_id, $dataVal, $bookingData->host_id);

        return redirect()->route('payment_success', ['bookingId' => $bookingId]);
    }

    public function cancel($bookingId, $bookingData)
    {
        return '/payment_methods?booking=' . $bookingId;
    }

    public function return($bookingId, $requestData)
    {
        // Return doesn't require a separate return handling
    }

    public function callback($bookingId, $requestData)
    {
        // Return doesn't require a separate callback handling
    }

    public function refund($bookingId, $bookingData)
    {
        // Implement the refund logic for Offline
    }
}
