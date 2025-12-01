<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait};
use App\Models\{VehicleOdometer};
use Gate;
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class VehicleOdometerAPiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;

    public function vechileodometer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $vehicleOdoMeterData = VehicleOdometer::all();
            $formattedData = [];

            foreach ($vehicleOdoMeterData as $odoMeter) {
                $formattedData[] = [
                    'id' => $odoMeter->id,
                    'odometer' => $odoMeter->name,
                ];
            }
            return $this->addSuccessResponse(200,trans('front.Result_found'), ['getodometer' => $formattedData]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
    public function odometerModelYear(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }


            $currentYear = date('Y');
            $formattedData = [];

            for ($i = $currentYear; $i >= $currentYear - 30; $i--) {
                $formattedData[] = $i;
            }

            // return response()->json(['getYear' => $formattedData], 200);
            return $this->addSuccessResponse(200,trans('front.Result_found'), ['getYear' => $formattedData]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
    public function odometermannual(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'module_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $formattedData = [];
            $formattedData[] = ['option' => 'manual'];

            $formattedData[] = ['option' => 'automatic'];

            return $this->addSuccessResponse(200,trans('front.Result_found'), ['options' => $formattedData]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
}
