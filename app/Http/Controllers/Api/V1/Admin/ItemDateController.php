<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait};
use Gate;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DateTime;
use App\Models\Modern\{Item, ItemDate, Currency};

class ItemDateController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;
    /**
     * Get item dates for a specific Items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getItemDates(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'item_id' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }
          $itemId = $request->input('item_id');
            $singleItemData = Item::where('id', $itemId)->firstOrFail();
            if (!$singleItemData) {
                return $this->addErrorResponse(500,trans('front.item_not_found'), '');
            }

            $selectedCurrencyCode = $request->input('selected_currency_code');
            $convertionRate = Currency::getValueByCurrencyCode($selectedCurrencyCode);

            $itemDates = ItemDate::where('item_id', $itemId)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date', 'asc')
                ->get();
            $availableDates = [];
            $notAvailableDates = [];
            $booked_dates = [];
            foreach ($itemDates as $date) {
                if ($date->status === 'Available') {
                    $availableDates[] = [
                        'date' => $date->date,
                        'price' => $date->price,
                    ];
                } elseif ($date->status === 'Not available' && $date->booking_id > 0) {
                    $booked_dates[] = [
                        'date' => $date->date,
                        'price' => $date->price,
                    ];
                } else {
                    
                    $notAvailableDates[] = [
                        'date' => $date->date,
                        'price' => $date->price,
                    ];
                }
            }
            $notAvailableDatesMap = [];
                foreach ($notAvailableDates as $dateInfo) {
                    $notAvailableDatesMap[$dateInfo['date']] = $dateInfo['price'];
                }
                $availableDatesMap = [];
                foreach ($availableDates as $dateInfo) {
                    $availableDatesMap[$dateInfo['date']] = $dateInfo['price'];
                }
            $startDate = new DateTime();
                $endDate = (new DateTime())->modify('+2 months');
                while ($startDate <= $endDate) {
                    $dateStr = $startDate->format('Y-m-d');
                    if (isset($notAvailableDatesMap[$dateStr])) {
                        $startDate->modify('+1 day');
                        continue;
                    }
                    if (isset($availableDatesMap[$dateStr])) {
                        $startDate->modify('+1 day');
                        continue;
                    }
                    $availableDates[] = [
                        'date' => $dateStr,
                        'price' => $singleItemData->price,
                    ];
                    $availableDatesMap[$dateStr] = $singleItemData->price;
                    $startDate->modify('+1 day');
                }

            $itemData['available_dates'] = $availableDates;
            $itemData['not_available_dates'] = $notAvailableDates;
            $itemData['booked_dates'] = $booked_dates;

            return $this->addSuccessResponse(200,trans('front.Result_found'), ['ItemDates' => $itemData]);
        } catch (\Exception $exception) {
            return $this->addErrorResponse(500, $exception->getMessage(), '');
        }
    }

    public function addEditCalender(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:rental_items,id',
            'token' => 'required|exists:app_users,token',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

      $user_id = $this->checkUserByToken($request->token);
        if (!$user_id) {
            return $this->addErrorResponse(419, trans('front.token_not_match'), '');
        }
        try {
            $itemData = Item::where('id', $request->input('id'))->where('userid_id', $user_id)->first();
    
            if ($request->has('availability_dates')) {
                $availabilityDatesArray = json_decode($request->input('availability_dates'), true);
                foreach ($availabilityDatesArray as $index => $availabilityDates) {
                    foreach ($availabilityDates as $dateData) {
                        $date = $dateData['date'];
                        $status = $dateData['status'];
                        $price = $dateData['price'];
    
                        $itemDate = ItemDate::firstOrNew([
                            'item_id' => $itemData->id,
                            'date' => $date,
                        ]);
                        if ($itemDate->booking_id > 0) {
                            continue;
                        } else {
                            $itemDate->status = $status;
                            $itemDate->price = $price;
                            $itemDate->range_index = $index;
                            $itemDate->save();
    
                        }
    
                    }
                }
            }
            $steps = json_decode($itemData->steps_completed, true);
            if (isset($steps['calendar']) && !$steps['calendar']) {
                $steps['calendar'] = true;
                
                
                if($itemData->step_progress < 100){
                $itemData->step_progress = $itemData->step_progress + 11.11;
                }
                $itemData->steps_completed = json_encode($steps);
            
                $itemData->save();
            }
           
           
            return $this->addSuccessResponse(200, trans('date_added_successfully'), $itemData);
        } 
        catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

}