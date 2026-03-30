<?php

namespace App\Http\Controllers\Traits;

use DB;
use Carbon\Carbon;
use App\Models\{AppUser, VehicleFuelType, Booking, GeneralSetting, AddCoupon, VehicleMake, SubCategory, VehicleOdometer, CancellationPolicy, RentalItemRule, AppUserMeta, AllPackage};
use App\Models\Modern\{Item, ItemMeta, ItemType, ItemDate, Currency, ItemVehicle, ItemFeatures};

use NumberFormatter;

trait MiscellaneousTrait
{

    /**
     * Format the item data with front image.
     *
     * @param  \App\Models\Item  $item
     * @return array
     */

    public function formatItemData($itemDetail, $convertionRate = 1)
    {
        $frontImage = $itemDetail->front_image;
        // $frontImageUrl = $frontImage ? $frontImage->thumbnail : null;
        $frontImageUrl = $frontImage ? $frontImage->url : null;

        return [
            'id' => $itemDetail->id,
            'name' => $itemDetail->title,
            'item_rating' => (string) $itemDetail->item_rating,
            'address' => $itemDetail->address,
            'state_region' => $itemDetail->state_region,
            'city' => $itemDetail->state_region,
            'zip_postal_code' => (string) $itemDetail->zip_postal_code,
            'price' => (string) $itemDetail->price,
            'latitude' => $itemDetail->latitude,
            'longitude' => $itemDetail->longitude,
            'status' => (string) $itemDetail->status,
            'item_type_id' => (string) $itemDetail->item_type_id,
            'image' => $frontImageUrl,
            'item_info' => ItemMeta::getMetaValue($itemDetail->id, 'itemMetaInfo')
        ];
    }
    public function checkUserByToken($token)
    {

        $tokendata = AppUser::where('token', trim($token))->where('status', 1)->first();

        if ($tokendata) {
            return $tokendata->id;
        } else {
            return '';
        }
    }

    public function getGeneralSettingValue($key)
    {
        $setting = GeneralSetting::where('meta_key', $key)
            ->first();

        if ($setting) {
            return $setting->meta_value;
        }

        return null;
    }
    public function getItemPricesDetails($ItemId, $checkIn, $checkOut, $force, $couponCode, $wallet_amount = 0, $token = 0, $totalTime = [], $selectedCurrencyCode = 'USD', $convertionRate = 1, $end_time = 0, $doorStep_price = 0,$forDb=0)
    {

        $dates = [];
        $currentDate = Carbon::parse($checkIn);
        $endDate = Carbon::parse($checkOut);
        $itemData = Item::findOrFail($ItemId);
        $itemMetas = $itemData->itemMeta->pluck('meta_value', 'meta_key');

        while ($currentDate < $endDate) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay(); // Increment by one day
        }
        $selectedCurrencyCode = $selectedCurrencyCode;
        $convertionRate = Currency::getValueByCurrencyCode($selectedCurrencyCode);
        // Check availability of Item dates
        $itemDates = ItemDate::where('item_id', $ItemId)
            ->whereIn('date', $dates)
            ->get();
        $force = true;
        if ($itemDates->where('status', 'Not available')->count() > 0 && !$force) {
            $result['status'] = "Not available";
            return $this->addErrorResponse(500, trans('front.this_item_is_already_booked'), $result);
        }

        $basePrice = $itemData->price;
        $totalPrice = 0;
        $couponDiscount = 0;
        $response = [];
        $date_with_price = [];
        $TotalDurationNumber = '';
        $TotalDurationLabel = '';
        $index = 1;
        foreach ($dates as $date) {
            $matchingDate = $itemDates->firstWhere('date', $date);
            if ($matchingDate && $matchingDate->status === 'Available') {
                $price = $matchingDate->price > 0 ? $matchingDate->price : $itemData->price;
                $status = 'Available';
            } else {
                $price = $itemData->price;
                $status = 'Available';
            }
            if (!empty($totalTime) && $totalTime['totalDays'] > 0) {
                if ($index <= $totalTime['totalDays']) {
                    $totalPrice += $price;
                }
            } else {
                $totalPrice += $price;
            }

            $date_with_price[] = [
                'date' => $date,
                'price' => $this->formatPriceWithConversion(
                    $price,
                    $selectedCurrencyCode,
                    $convertionRate
                ),
                'status' => $status,
            ];
            $index++;
        }

        if (!empty($totalTime) && $totalTime['totalDays']) // This for Vechile
            $bookingDuration = $totalTime['totalDays'];
        else
            $bookingDuration = count($dates);


        $TotalDurationNumber = $bookingDuration;
        $TotalDurationLabel = 'Days';
        $weeklyDiscount = $itemMetas->get('weekly_discount');
        $monthlyDiscount = $itemMetas->get('monthly_discount');
        $weeklyDiscountType = $itemMetas->get('weekly_discount_type');
        $monthlyDiscountType = $itemMetas->get('monthly_discount_type');
        $response['discount_type'] = '';
        $discountPrice = 0;
        if ($bookingDuration >= 30 && $monthlyDiscountType !== null) {
            // Apply the monthly discount based on the discount type
            if ($monthlyDiscountType === 'percent') {
                $discountPrice = ($totalPrice * $monthlyDiscount) / 100;
            } else {
                $discountPrice = $monthlyDiscount;
            }
            $response['discount_type'] = 'Monthly Discount';
            $totalPrice -= $discountPrice;
        } else if ($bookingDuration >= 7 && $weeklyDiscountType !== null) {
            // Apply the weekly discount based on the discount type
            if ($weeklyDiscountType === 'percent') {
                $discountPrice = ($totalPrice * $weeklyDiscount) / 100;
            } else {
                $discountPrice = $weeklyDiscount;
            }
            $response['discount_type'] = 'Weekly Discount';
            $totalPrice -= $discountPrice;
        }


        if ($couponCode) {

            $checkdata = AddCoupon::where('coupon_code', $couponCode)->first();

            if ($checkdata) {
                $couponValue = $checkdata->coupon_value;
                $couponType = $checkdata->coupon_type;
                $minOrderAmount = $checkdata->min_order_amount;

                if ($totalPrice >= $minOrderAmount) {
                    if ($couponType === 'percentage') {
                        $couponDiscount = ($totalPrice * $couponValue) / 100;
                    } else {
                        $couponDiscount = $couponValue;
                    }

                    $totalPrice = max(0, $totalPrice - $couponDiscount);
                } else {
                    $couponDiscount = 0;
                }
            } else {
                $couponDiscount = 0;
            }
        }

        // Calculate gross price, including fees
        $wallet_amount_apply = 0;
        $remaining_wallet_balance = 0;
        $cleaningFee = 0;
        $security_fee = 0;
        $cleaningFee = floatval(ItemMeta::getMetaValue($ItemId, 'cleaning_fee') ?? 0);
        $security_fee = floatval(ItemMeta::getMetaValue($ItemId, 'security_fee') ?? 0);
        $accommodationFee = $itemData->accommodation_fee;

        $service_charge = ($totalPrice * $this->getGeneralSettingValue('feesetup_guest_service_charge')) / 100;
        $cleaning_charge = ($totalPrice * $cleaningFee) / 100;
        $security_deposit = $security_fee;


        //$tax = floatval($totalPrice * $this->getGeneralSettingValue('feesetup_iva_tax')) / 100;
        $ivaTaxSetup = $this->getGeneralSettingValue('feesetup_iva_tax');
        $tax = floatval($totalPrice * $ivaTaxSetup) / 100;


        if ($itemData['module'] == 2) {

            $service_charge = 0;
            $cleaning_charge = 0;
        }
        $doorStep_delivery_price = 0;

        if ($doorStep_price > 0) {

            $doorStep_delivery_price = floatval(ItemMeta::getMetaValue($ItemId, 'doorStep_price') ?? 0);
        }

        $calculateHours = $totalTime['totalHours'] ?? 0;

        if ($calculateHours > 0 && $calculateHours <=12 ) {
            $totalPrice = $totalPrice * 0.6;
        }
        
        $grossPrice = $totalPrice + $security_deposit + $service_charge +  $tax + $doorStep_delivery_price;

        $totalPrice2 = $grossPrice;

        if ($wallet_amount) {
            $wallet_amount_apply = $wallet_amount > $grossPrice ? $grossPrice : $wallet_amount;
            $grossPrice -= $wallet_amount_apply;
            $remaining_wallet_balance = $wallet_amount - $wallet_amount_apply;
        }


        // $calculateHours = $totalTime['totalHours'] ?? 0;

        // if ($calculateHours > 0 && $calculateHours <=12 ) {
        //     $grossPrice = $grossPrice * 0.6;
        // }


        $priceBeforeDiscount = $totalPrice + $discountPrice + $couponDiscount;
        $pricePerDay = $priceBeforeDiscount / $bookingDuration;

        // Add total, discount, gross prices, and coupon discount to the response
        $response['prices'] = $date_with_price;
        $response['base_price_commission'] = (string) (formatCurrencyForDb($totalPrice,$forDb));
        $response['price_before_discount'] = (string) (formatCurrencyForDb(($totalPrice + $discountPrice + $couponDiscount),$forDb));
        $response['price_per_day'] = (string) formatCurrencyForDb($pricePerDay,$forDb);
        $response['total_days'] = (string) ($bookingDuration);
        $response['discount_price'] = (string) ($discountPrice > 0 ? formatCurrencyForDb($discountPrice,$forDb) : 0);
        $response['coupon_discount'] = (string) ($couponDiscount > 0 ? formatCurrencyForDb($couponDiscount,$forDb) : 0);
        $response['price_after_discount'] = (string) ($totalPrice > 0 ? formatCurrencyForDb($totalPrice,$forDb) : 0);
        $response['service_charge'] = (string) ($service_charge > 0 ? formatCurrencyForDb($service_charge,$forDb) : 0);
        $response['cleaning_charge'] = (string) ($cleaning_charge > 0 ? formatCurrencyForDb($cleaning_charge,$forDb) : 0);
        $response['security_deposit'] = (string) ($security_deposit > 0 ? formatCurrencyForDb($security_deposit,$forDb) : 0);
        $response['doorStep_price'] = (string) ($doorStep_delivery_price > 0 ? formatCurrencyForDb($doorStep_delivery_price,$forDb) : 0);
        $response['coupon_code'] = $couponCode;
        $response['feesetup_iva_tax'] = (string) ($ivaTaxSetup > 0 ? $ivaTaxSetup : 0);
        $response['tax'] = (string) ($tax > 0 ? formatCurrencyForDb($tax,$forDb) : 0);
        $response['wallet_amount'] = (string) ($wallet_amount_apply > 0 ? formatCurrencyForDb($wallet_amount_apply,$forDb) : 0);
        $response['remaining_wallet_balance'] = (string) ($remaining_wallet_balance > 0 ? formatCurrencyForDb($remaining_wallet_balance,$forDb) : 0);
        $response['gross_price'] = (string) ($grossPrice > 0 ? formatCurrencyForDb($grossPrice,$forDb) : 0);
        $response['duration'] = $TotalDurationNumber;
        $response['label'] = $TotalDurationLabel;
        $response['totalPrice'] = (string) ($totalPrice2 > 0 ? formatCurrencyForDb($totalPrice2,$forDb) : 0);

        $priceFields = [
            'price_before_discount',
            'price_per_day',
            'discount_price',
            'coupon_discount',
            'price_after_discount',
            'service_charge',
            'cleaning_charge',
            'security_deposit',
            'tax',
            'wallet_amount',
            'remaining_wallet_balance',
            'gross_price',
            'totalPrice'
        ];

        foreach ($priceFields as $field) {
            $response[$field] = $this->formatPriceWithConversion(
                $response[$field],
                $selectedCurrencyCode,
                $convertionRate
            );
        }

        try {
            return $this->addSuccessResponse(200, 'item prices calculated successfully', $response);
        } catch (\Exception $e) {
            // Handle exceptions here
            return $this->addErrorResponse(500, 'Internal server error', $e->getMessage());
        }
    }


    function parseDataFromResponse($responseString)
    {
        // Use regular expression to extract JSON data.
        $pattern = '/\{(?:[^{}]|(?R))*\}/';
        if (preg_match($pattern, $responseString, $matches)) {
            $jsonData = $matches[0];

            $data = json_decode($jsonData, true);

            if ($data !== null && isset($data['data'])) {
                return $data['data'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function rollbackItemAvailability($itemId, $checkIn, $checkOut)
    {

        DB::beginTransaction();
        $dates = [];
        $currentDate = Carbon::parse($checkIn);
        $endDate = Carbon::parse($checkOut);

        while ($currentDate < $endDate) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        ItemDate::where('item_id', $itemId)
            ->whereIn('date', $dates)
            ->where('status', 'Not available')
            ->update(['status' => 'Available']);

        DB::commit();
    }



    function convertFormattedNumber($value, $commaAsDecimalPoint = false)
    {
        if ($commaAsDecimalPoint) {
            $value = str_replace(',', '.', $value);
            $value = str_replace('.', '', $value);
            $count = substr_count($value, '.');
            if ($count > 1) {
                $value = substr_replace($value, '', strrpos($value, '.'), 1);
            }
            return (float) $value;
        } else {
            return (float) str_replace(',', '', $value);
        }
    }


    public function getModuleIdOrDefault($request, $default = 1)
    {

        return $request->input('module_id', $default);
    }

    public function insertItemMetaData($request, $module, $id)
    {
        $metaData = json_decode($request->input('metaData'));
        $selectedRules = [];
        if (isset($metaData->rules)) {
            $selectedRules = implode(',', $metaData->rules);
        }

        switch ($module) {
            case 1:
                $data = [
                    'cleaning_fee' => $metaData->cleaning_fee ?? 0,
                    'additional_fee' => $metaData->additional_fee ?? 0,
                    'security_fee' => $metaData->security_fee ?? 0,
                    'weekend_price' => $metaData->weekend_price ?? 0,
                    'rules' => $selectedRules,
                ];
                $this->addOrUpdateItemMeta($id, $data);
                $item = Item::where('id', $id)->first();
                if ($item) {
                    $item->update([
                        'service_type' => $metaData->service_type
                    ]);
                }
                break;

            case 2:
                $data = [
                    'security_fee' => $metaData->security_fee ?? 0,
                    'doorStep_price' => $metaData->doorStep_price ?? 0,
                    'rules' => $selectedRules ?? NULL,
                ];

                $itemVehicleData = [
                    'year' =>  $metaData->year ?? NULL,
                    'transmission' => $metaData->transmission ?? NULL,
                    'odometer' => $metaData->odometer ?? NULL,
                    'number_of_seats' => $metaData->number_of_seats,
                    'fuel_type_id' => $metaData->fuel_type_id ?? NULL,
                ];


                $identifier = [
                    'item_id' => $id
                ];

                $itemVehicle = ItemVehicle::updateOrCreate($identifier, $itemVehicleData);

                $Vechile = Item::where('id', $id)->first();

                if ($Vechile) {
                    $Vechile->update([
                        'category_id' => $metaData->category_id,
                        'subcategory_id' => $metaData->subcategory_id,
                        'service_type' => $metaData->service_type
                    ]);
                }

                $this->addOrUpdateItemMeta($id, $data);
                break;

            case 3:
                $data = [
                    'boat_length' => $metaData->boat_length ?? NULL,
                    'year' => $metaData->year ?? NULL,
                    'rules' => $selectedRules ?? NULL,
                ];
                $this->addOrUpdateItemMeta($id, $data);

                $item = Item::where('id', $id)->first();
                if ($item) {
                    $item->update([
                        'service_type' => $metaData->service_type
                    ]);
                }
                break;

            case 4:
                $data = [
                    'price_per_week' => $metaData->price_per_week ?? NULL,
                    'price_per_day' => $metaData->price_per_day ?? NULL,
                    'additional_hour_price' => $metaData->additional_hour_price ?? NULL,
                    'parking_extrance' => $metaData->parking_extrance ?? NULL,
                    'number_of_parking_slots' => $metaData->number_of_parking_slots ?? NULL,
                    'enable_parking_slot' => $metaData->enable_parking_slot ?? NULL,
                    'rules' => $selectedRules ?? NULL,
                ];
                $this->addOrUpdateItemMeta($id, $data);
                break;

            case 5:
                $data = [
                    'style_note' => $metaData->style_note ?? NULL,
                    'rules' => $selectedRules ?? NULL,
                    'security_fee' => $metaData->security_fee ?? 0,
                ];

                $BookableData = Item::where('id', $id)->first();

                if ($BookableData) {
                    $BookableData->update([
                        'category_id' => $metaData->category_id,
                        'subcategory_id' => $metaData->subcategory_id,
                        'service_type' => $metaData->service_type
                    ]);
                }

                $this->addOrUpdateItemMeta($id, $data);
                break;



            case 6:
                $data = [
                    'hours_discount' => $metaData->hours_discount ?? NULL,
                    'working_hour_list' => json_encode($metaData->working_hour_list) ?? NULL,
                    'cleaning_fees' => $metaData->cleaning_fees ?? NULL,
                    'rules' => $selectedRules ?? NULL,
                ];
                $this->addOrUpdateItemMeta($id, $data);
                break;

            default:
                return []; // Add a default case to return an empty array if module doesn't match any case
        }
    }


    public function returnItemMetaData($id, $module)
    {

        switch ($module) {
            case 1:
                $item = Item::where('id', $id)->first();
                $data = [
                    'cleaning_fee' => ItemMeta::getMetaValue($id, 'cleaning_fee') ?? 0,
                    'additional_fee' => ItemMeta::getMetaValue($id, 'additional_fee') ?? 0,
                    'security_fee' => ItemMeta::getMetaValue($id, 'security_fee') ?? 0,
                    'service_type' => $item->service_type ?? '',
                    'weekend_price' => ItemMeta::getMetaValue($id, 'weekend_price') ?? 0,
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                ];

                break;

            case 2:

                $Vechile = Item::where('id', $id)->first();
                $itemVehicle = ItemVehicle::where('item_id', $id)->first();
                $data = [
                    'year' => $itemVehicle->year ?? NULL,
                    'transmission' => $itemVehicle->transmission ?? NULL,
                    'odometer' => $itemVehicle->odometer ?? NULL,
                    'number_of_seats' => $itemVehicle->number_of_seats ?? 0,
                    'fuel_type' => $itemVehicle->fuel_type_id ?? NULL,
                    'doorStep_price' => ItemMeta::getMetaValue($id, 'doorStep_price') ?? 0,
                    'security_fee' => ItemMeta::getMetaValue($id, 'security_fee') ?? 0,
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                    'service_type' => $Vechile->service_type ?? '',
                    'category_id' => $Vechile->category_id ?? NULL,
                    'subcategory_id' => $Vechile->subcategory_id ?? NULL,
                ];

                break;

            case 3:
                $item = Item::where('id', $id)->first();
                $data = [
                    'boat_length' => ItemMeta::getMetaValue($id, 'boat_length') ?? NULL,
                    'year' => ItemMeta::getMetaValue($id, 'year') ?? NULL,
                    'service_type' => $item->service_type ?? '',
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                ];

                break;

            case 4:
                $data = [
                    'price_per_week' => ItemMeta::getMetaValue($id, 'price_per_week') ?? NULL,
                    'price_per_day' => ItemMeta::getMetaValue($id, 'price_per_day') ?? NULL,
                    'additional_hour_price' => ItemMeta::getMetaValue($id, 'additional_hour_price') ?? NULL,
                    'parking_extrance' => ItemMeta::getMetaValue($id, 'parking_extrance') ?? NULL,
                    'number_of_parking_slots' => ItemMeta::getMetaValue($id, 'number_of_parking_slots') ?? NULL,
                    'enable_parking_slot' => ItemMeta::getMetaValue($id, 'enable_parking_slot') ?? NULL,
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                ];

                break;

            case 5:
                $BookableData = Item::where('id', $id)->first();

                $data = [
                    'style_note' => ItemMeta::getMetaValue($id, 'style_note') ?? NULL,
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                    'category_id' => $BookableData->category_id ?? NULL,
                    'service_type' => $BookableData->service_type ?? '',
                    'security_fee' => ItemMeta::getMetaValue($id, 'security_fee') ?? 0,
                    'subcategory_id' => $BookableData->subcategory_id ?? NULL,
                ];

                break;

            case 6:
                $data = [
                    'hours_discount' => ItemMeta::getMetaValue($id, 'hours_discount') ?? NULL,
                    'working_hour_list' => json_decode(ItemMeta::getMetaValue($id, 'working_hour_list')) ?? NULL,
                    'cleaning_fees' => ItemMeta::getMetaValue($id, 'cleaning_fees') ?? NULL,
                    'rules' => array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules'))) ?? NULL,
                ];

                break;

            default:
                return [];
        }
        return json_encode($data);
    }

    public function getModuleInfoValues($moduleId = '', $id, $request = null)
    {
        $metaData = array();
        $itemDetail = Item::find($id);
        $playerIdMeta = $itemDetail->appUser->metadata->firstWhere('meta_key', 'player_id');
        if (isset($itemDetail->appUser->profile_image->preview_url)) {
            $host_profile_image = $itemDetail->appUser->profile_image->preview_url;
        } else {
            $host_profile_image = null;
        }

        $galleryImages = $itemDetail->gallery;

        $galleryImageUrls = [];
        foreach ($galleryImages as $image) {
            $galleryImageUrls[] = $image->url;
        }

        if (!$itemDetail) {
            return null;
        }
        $distance = "";
        if ($request && $request->has(['latitude', 'longitude'])) {
            $userLatitude = $request->input('latitude');
            $userLongitude = $request->input('longitude');
            $distance = $this->calculateDistance($userLatitude, $userLongitude, $itemDetail->latitude, $itemDetail->longitude);
            $distance .= " km";
        }


        $moduleId = $itemDetail->module ?? 1;
        $rules = array_map('intval', explode(',', ItemMeta::getMetaValue($id, 'rules')));
        $metaData['distance'] = $distance;

        $itemMetaData = ItemMeta::where('rental_item_id', $id)
            ->whereIn('meta_key', ['weekly_discount', 'weekly_discount_type', 'monthly_discount', 'monthly_discount_type', 'doorStep_price'])
            ->get()
            ->keyBy('meta_key');


        $features = ItemFeatures::whereIn('id', explode(',', $itemDetail->features_id))->get();
        $featuresData = [];
        foreach ($features as $feature) {
            $featuresData[] = [
                'id' => $feature->id,
                'name' => $feature->name,
                'image_url' => $feature->icon ? $feature->icon->url : null,
            ];
        }

        $reviewData = [];
        foreach ($itemDetail->reviews as $review) {

            if (empty($review->guest->profile_image->url)) {
                $profile_image = 'null';
            } else {
                $profile_image = $review->guest->profile_image->url;
            }
            $reviewData[] = [
                'id' => $review->id,
                'booking_id' => (string) $review->bookingid,
                'guest_id' => (string) $review->guestid,
                'guest_name' => $review->guest_name,
                'guest_profile_image' => $profile_image,
                'rating' => (string) $review->guest_rating,
                'message' => $review->guest_message,
                'created_at' => $review->created_at->format('F Y'),
                'updated_at' => $review->updated_at->format('F Y'),
            ];
        }

        // $bookingPolicies = CancellationPolicy::all()->map(function ($policy) {
        //     return [
        //         'id' => $policy->id,
        //         'name' => $policy->name,
        //         'description' => $policy->description,
        //         'value' => $policy->value,
        //         'type' => $policy->type,
        //         'cancellation_time' => $policy->cancellation_time,
        //     ];
        // });
        $cancelAtionPolicyDescriptions = CancellationPolicy::all()->pluck('description')->toArray();

        switch ($moduleId) {
            case 1:
                $metaData = [
                    'service_type' => $itemDetail->service_type ? $itemDetail->service_type : '',
                    'rules' => RentalItemRule::getRuleNamesByIds($rules) ?? NULL,
                ];
                return json_encode($metaData);

            case 2:
                // $itemMetaData = ItemMeta::where('rental_item_id', $id)
                //     ->whereIn('meta_key', ['you_listing', 'make_type', 'model', 'year', 'transmission', 'odometer', 'rules'])
                //     ->get()
                //     ->keyBy('meta_key');
                $itemVehicle = ItemVehicle::where('item_id', $id)->first();
                $metaData = [
                    'service_type' => $itemDetail->service_type ? $itemDetail->service_type : '',
                    'rules' => RentalItemRule::getRuleNamesByIds($rules) ?? NULL,
                    'vehicleType' => $itemDetail->item_type_id ? $this->getoVehicleType($itemDetail->item_type_id) : '',
                    'make_type' => $itemDetail->category_id ? $this->getMakeName($itemDetail->category_id) : '',
                    'model' => $itemDetail->subcategory_id ? $this->getModelName($itemDetail->subcategory_id) : '',
                    // 'year' => $itemVehicle->year ? $itemVehicle->year : '',
                    // 'transmission' => $itemVehicle->transmission ? $itemVehicle->transmission : '',
                    // 'odometer' => $itemVehicle->odometer ? $this->getodometerName($itemVehicle->odometer) : '',
                    // 'number_of_seats' => $itemVehicle->number_of_seats,
                    // 'fuel_type' => $itemVehicle->fuel_type_id ? $this->getFuelTypeName($itemVehicle->fuel_type_id) : '',
                    'year' => $itemVehicle && $itemVehicle->year ? $itemVehicle->year : '',
                    'transmission' => $itemVehicle && $itemVehicle->transmission ? $itemVehicle->transmission : '',
                    'odometer' => $itemVehicle && $itemVehicle->odometer ? $this->getodometerName($itemVehicle->odometer) : '',
                    'number_of_seats' => $itemVehicle ? $itemVehicle->number_of_seats : '',
                    'fuel_type' => $itemVehicle && $itemVehicle->fuel_type_id ? $this->getFuelTypeName($itemVehicle->fuel_type_id) : '',
                    'description' => $itemDetail->description ? $itemDetail->description : '',
                    'is_verified' => $itemDetail->is_verified ? $itemDetail->is_verified : '',
                    'is_featured' => $itemDetail->is_featured ? $itemDetail->is_featured : '',
                    'booking_policies_id' => $itemDetail->booking_policies_id ? $itemDetail->booking_policies_id : '',
                    'weekly_discount' => $itemMetaData->get('weekly_discount') ? $itemMetaData->get('weekly_discount')->meta_value : '',
                    'weekly_discount_type' => $itemMetaData->get('weekly_discount_type') ? $itemMetaData->get('weekly_discount_type')->meta_value : '',
                    'monthly_discount' => $itemMetaData->get('monthly_discount') ? $itemMetaData->get('monthly_discount')->meta_value : '',
                    'monthly_discount_type' => $itemMetaData->get('monthly_discount_type') ? $itemMetaData->get('monthly_discount_type')->meta_value : '',
                    'doorStep_price' => $itemMetaData->get('doorStep_price') ? $itemMetaData->get('doorStep_price')->meta_value : 0,
                    'cancellation_reason_title' => 'Cancellation Policy',
                    'cancellation_reason_description' => $cancelAtionPolicyDescriptions ? $cancelAtionPolicyDescriptions : '',
                    'features_data' => $featuresData,
                    'host_id' => $itemDetail->appUser ? $itemDetail->appUser->id : '',
                    'host_first_name' => $itemDetail->appUser ? $itemDetail->appUser->first_name : '',
                    'host_last_name' => $itemDetail->appUser ? $itemDetail->appUser->last_name : '',
                    'host_email' => $itemDetail->appUser ? $itemDetail->appUser->email : '',
                    'host_phone' => $itemDetail->appUser ? $itemDetail->appUser->phone : '',
                    'host_player_id' => $playerIdMeta ? $playerIdMeta->meta_value : '',
                    'host_profile_image' => $host_profile_image,
                    'gallery_image_urls' => $galleryImageUrls,
                    'review_data' => $reviewData,
                    'total_reviews' => $itemDetail->reviews->count(),
                ];

                return json_encode($metaData);

            case 3:
                $itemMetaData = ItemMeta::where('rental_item_id', $id)
                    ->whereIn('meta_key', ['boat_length', 'year', 'rules'])
                    ->get()
                    ->keyBy('meta_key');
                $metaData['boatType'] = $itemDetail->item_type_id ? $this->getoVehicleType($itemDetail->item_type_id) : '';
                $metaData['service_type'] = $itemDetail->service_type ? $itemDetail->service_type : '';
                $metaData['year'] = $itemMetaData->get('year') ? $itemMetaData->get('year')->meta_value : '';
                $metaData['rules'] = RentalItemRule::getRuleNamesByIds($rules) ?? NULL;


                return json_encode($metaData);

            case 4:
                $itemType = ItemType::find($itemDetail->item_type_id);
                $metaData['parkingType'] = $itemType ? $itemType->name : '';
                // $metaData['parkingType'] = $itemType->name;
                $metaData['parkingTypeIcon'] = isset($itemType->image) ? $itemType->image->url : NULL;
                $metaData['parking_slots'] = ItemMeta::getMetaValue($id, 'number_of_parking_slots') ?? NULL;
                $metaData['time_interval'] = ItemMeta::getMetaValue($id, 'parkingDuration') ?? NULL;
                $metaData['start_time'] = ItemMeta::getMetaValue($id, 'fromTime') ?? NULL;
                $metaData['end_time'] = ItemMeta::getMetaValue($id, 'toTime') ?? NULL;
                $metaData['enable_parking_slot'] = ItemMeta::getMetaValue($id, 'enable_parking_slot') ?? 'off';
                $metaData['distance'] = '2.0';
                $metaData['time'] = '7';
                $metaData['rules'] = RentalItemRule::getRuleNamesByIds($rules) ?? NULL;


                return json_encode($metaData);

            case 5:
                $metaData['service_type'] = $itemDetail->service_type ? $itemDetail->service_type : '';
                $metaData['rules'] = RentalItemRule::getRuleNamesByIds($rules) ?? NULL;

            case 6:
                $workingHours = json_decode(ItemMeta::getMetaValue($id, 'working_hour_list'), true);
                $weeklyTiming = [];

                $weeklyTiming['monday']['start_time'] = isset($workingHours[0]['monday_opening_time']) ? $workingHours[0]['monday_opening_time'] : '0:00';
                $weeklyTiming['monday']['end_time'] = isset($workingHours[0]['monday_closing_time']) ? $workingHours[0]['monday_closing_time'] : '0:00';

                $weeklyTiming['tuesday']['start_time'] = isset($workingHours[1]['tuesday_closing_time']) ? $workingHours[1]['tuesday_opening_time'] : '0:00';
                $weeklyTiming['tuesday']['end_time'] = isset($workingHours[1]['tuesday_closing_time']) ? $workingHours[1]['tuesday_closing_time'] : '0:00';

                $weeklyTiming['wednesday']['start_time'] = isset($workingHours[2]['wednesdayclosing_time']) ? $workingHours[2]['wednesday_opening_time'] : '0:00';
                $weeklyTiming['wednesday']['end_time'] = isset($workingHours[2]['wednesday_closing_time']) ? $workingHours[2]['wednesday_closing_time'] : '0:00';

                $weeklyTiming['thursday']['start_time'] = isset($workingHours[3]['thursday_closing_time']) ? $workingHours[3]['thursday_opening_time'] : '0:00';
                $weeklyTiming['thursday']['end_time'] = isset($workingHours[3]['thursday_closing_time']) ? $workingHours[3]['thursday_closing_time'] : '0:00';

                $weeklyTiming['friday']['start_time'] = isset($workingHours[4]['friday_closing_time']) ? $workingHours[4]['friday_opening_time'] : '0:00';
                $weeklyTiming['friday']['end_time'] = isset($workingHours[4]['friday_closing_time']) ? $workingHours[4]['friday_closing_time'] : '0:00';

                $weeklyTiming['saturday']['start_time'] = isset($workingHours[5]['saturday_closing_time']) ? $workingHours[5]['saturday_opening_time'] : '0:00';
                $weeklyTiming['saturday']['end_time'] = isset($workingHours[5]['saturday_closing_time']) ? $workingHours[5]['saturday_closing_time'] : '0:00';

                $weeklyTiming['sunday']['start_time'] = isset($workingHours[6]['sunday_closing_time']) ? $workingHours[6]['sunday_opening_time'] : '0:00';
                $weeklyTiming['sunday']['end_time'] = isset($workingHours[6]['sunday_closing_time']) ? $workingHours[6]['sunday_closing_time'] : '0:00';
                $metaData['hours_discount'] = ItemMeta::getMetaValue($id, 'hours_discount') ?? null;

                $metaData['working_hour_list'] = json_decode(ItemMeta::getMetaValue($id, 'working_hour_list')) ?? null;

                $metaData['cleaning_fees'] = ItemMeta::getMetaValue($id, 'cleaning_fees') ?? null;
                $metaData['weekly_timing'] = json_encode($weeklyTiming);
                $metaData['rules'] = RentalItemRule::getRuleNamesByIds($rules) ?? null;
                return json_encode($metaData);
            default:

                return [];
        }
    }

    public function getMakeName($makeId)
    {
        $make = VehicleMake::find($makeId);

        return $make ? $make->name : '';
    }

    public function getModelName($modeld)
    {
        $model = SubCategory::find($modeld);

        return $model ? $model->name : '';
    }

    public function getodometerName($id)
    {
        $odometer = VehicleOdometer::find($id);

        return $odometer ? $odometer->name : '';
    }

    public function getFuelTypeName($id)
    {
        $fuelType = VehicleFuelType::find($id);

        return $fuelType ? $fuelType->name : '';
    }


    public function getoVehicleType($id)
    {
        $itemType = ItemType::find($id);

        return $itemType ? $itemType->name : '';
    }
    public function generateUniqueToken()
    {
        $timestamp = time();
        $randomChars = $this->generateRandomChars(60);
        $token = $timestamp . $randomChars;

        // Check uniqueness across all tables, regenerate if necessary
        while ($this->isTokenExistsInAnyTable($token)) {
            $timestamp = time();
            $randomChars = $this->generateRandomChars(60);
            $token = $timestamp . $randomChars;
        }
        $token = str_shuffle($token);
        return $token;
    }

    public function generateRandomChars($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomChars = '';

        for ($i = 0; $i < $length; $i++) {
            $randomChars .= $characters[random_int(0, $charactersLength - 1)];
        }

        return str_shuffle($randomChars);
    }

    public function isTokenExistsInAnyTable($token)
    {
        // Replace this with your logic to check if the token exists in any table
        // You might need to execute a query for each table or use another approach based on your database structure
        // Return true if the token exists in any table, false otherwise
        return false;
    }

    public function getTimeOptions()
    {
        $hours = [];

        for ($hour = 1; $hour <= 1; $hour++) {
            $minutes = $hour * 60;
            $hours["$hour hour"] = "{$minutes}";
        }

        return $hours;
    }


    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = number_format(($earthRadius * $c), 2);
        return $distance;
    }

    public function storeUserMeta($userId, $metaKey, $metaValue)
    {
        // Find existing meta or create a new one
        $meta = AppUserMeta::updateOrCreate(
            ['user_id' => $userId, 'meta_key' => $metaKey],
            ['meta_value' => $metaValue]
        );
    }
    public function formatPriceWithConversion($price, $currencyCode, $conversionRate, $locale = 'en_US', $calender = 0)
    {
        return $price;
        //   $price = str_replace(',', '', $price); 
        // $convertedPrice = $price * $conversionRate;
        // $formattedPrice = floatval($convertedPrice);

        // return strval($formattedPrice);
    }

    public function checkRemainingItems($userId, $module)
    {

        $itemCount = Item::where('userid_id', $userId)
            ->where('module', $module)
            ->count();

        $user = AppUser::where('id', $userId)->first();

        $package = AllPackage::where('id', $user->package_id)->first();
        if ($package) {

            if ($package->max_item <= $itemCount) {
                return null;
            }

            return $package->max_item - $itemCount;
        }
    }

    public function checkTotalNoOfBookingPerDay($userId)
    {
        $currentDate = date('Y-m-d');

        $bookingCount = Booking::where('userid', $userId)
            ->whereDate('created_at', $currentDate)
            ->count();


        $totalBookingsPerDaySetting = GeneralSetting::where('meta_key', 'total_number_of_bookings_per_day')
            ->pluck('meta_value')
            ->first();


        if ($bookingCount >= $totalBookingsPerDaySetting) {

            return null;
        }


        return $bookingCount;
    }

    public function createFirebaseUser($email, $password, $apiKey)
    {
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=" . $apiKey;
        $data = json_encode([
            'email' => $email,
            'password' => $password,
            'returnSecureToken' => true
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            // Decode the successful response
            $result = json_decode($response, true);
            return [
                'success' => true,
                'uid' => $result['localId'],
                'idToken' => $result['idToken'],
                'email' => $result['email']
            ];
        } else {
            // Decode the error response
            $error = json_decode($response, true);
            $errorMessage = isset($error['error']['message']) ? $error['error']['message'] : 'Unknown error occurred';

            if (strpos($errorMessage, 'EMAIL_EXISTS') !== false) {

                return [
                    'success' => true
                ];
            }

            return [
                'success' => false,
                'message' => $errorMessage
            ];
        }
    }

    public function getCurrencySymbolByCode($currencyCode)
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        return $currency ? $currency->currency_symbol : "₹";
    }
}
