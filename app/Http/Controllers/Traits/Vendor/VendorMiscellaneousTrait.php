<?php

namespace App\Http\Controllers\Traits\Vendor;

use DB;
use Carbon\Carbon;
use App\Models\{AppUser, Booking, GeneralSetting, AddCoupon, VehicleMake, SubCategory, VehicleOdometer, CancellationPolicy, RentalItemRule, AppUserMeta, AllPackage};
use App\Models\Modern\{Item, ItemMeta, ItemType, ItemDate, Currency, ItemVehicle, ItemFeatures};
use Gate;
use Symfony\Component\HttpFoundation\Response;
use NumberFormatter;

trait VendorMiscellaneousTrait
{

    /**
     * Format the item data with front image.
     *
     * @param  \App\Models\Item  $item
     * @return array
     */

     public function vendorItemAuthentication(int $itemId)
     {
         $item = Item::find($itemId);
 
         abort_if(!$item || $item->userid_id !== auth()->user()->id, Response::HTTP_FORBIDDEN, '403 Forbidden');
     }

}