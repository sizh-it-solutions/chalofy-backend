<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MiscellaneousTrait};
use App\Models\VehicleFuelType;
use Illuminate\Http\Request;
use Validator;

class VehicleFuelTypeApiController extends Controller
{
    use ResponseTrait, MiscellaneousTrait;

    public function getVehicleFuelTypes(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            // $fuelTypes = VehicleFuelType::all();
            $fuelTypes = VehicleFuelType::where('status', 1)->get();
            $formattedData = [];

            foreach ($fuelTypes as $fuelType) {
                $formattedData[] = [
                    'id' => $fuelType->id,
                    'fuel_type' => $fuelType->name,
                ];
            }

            return $this->addSuccessResponse(200,trans('front.Result_found'), ['fuel_types' => $formattedData]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
}
