<?php

namespace App\Http\Controllers\Admin\Vehicles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{MediaUploadingTrait, MiscellaneousTrait, CommonModuleItemTrait};
use App\Models\{SubCategory, Category, VehicleOdometer, VehicleFuelType};
use App\Models\Modern\{Item, ItemType, ItemVehicle};
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\BookingAvailableTrait;

class VehicleBaseController extends Controller
{

    use MediaUploadingTrait, BookingAvailableTrait, MiscellaneousTrait, CommonModuleItemTrait;

    public function base(Request $request, $id)
    {

        $itemVehicle = ItemVehicle::where('item_id', $id)->first();
        $YoulistingData = '';

        $YearData = $itemVehicle->year ?? null;
        $TransmissionData = $itemVehicle->transmission ?? null;
        $OdometerData = $itemVehicle->odometer ?? null;

        $vehicleTypeData = ItemType::where('module', 2)->get();
        $vehicleData = Item::where('id', $id)->first();
        $vehicleMakeData = Category::where('module', 2)->get();

        $MakeData = $vehicleData->category_id;
        $ModelData = $vehicleData->subcategory_id;

        $vehicleOdoMeterData = VehicleOdometer::all();
        if ($YoulistingData) {
        } else {
            $YoulistingData = '';
        }

        $fuelTypes = VehicleFuelType::all();

        return view('admin.vehicles.addVehicle.base', compact('id', 'fuelTypes', 'itemVehicle', 'vehicleMakeData', 'vehicleData', 'vehicleOdoMeterData', 'YoulistingData', 'MakeData', 'ModelData', 'YearData', 'TransmissionData', 'OdometerData', 'vehicleTypeData'));
    }
   

    public function baseUpdate(Request $request)
    {
        $request->validate([
            'car_type' => 'required|numeric',
            'make' => 'required|numeric',
            'model' => 'required|numeric',
            'year' => 'required|numeric',
            'number_of_seats' => 'required|numeric',
            'fuel_type' => 'required|exists:vehicle_fuel_type,id',
        ]);

        $id = $request->input('id');
        $car_type = $request->input('car_type');

        $itemData = Item::findOrFail($id);
        $itemData->update([
            'item_type_id' => $car_type,
            'category_id' => $request->input('make'),
            'subcategory_id' => $request->input('model')
        ]);

        $data = [
            'year' => $request->input('year'),
            'transmission' => $request->input('transmission'),
            'odometer' => $request->input('odometer'),
            'number_of_seats' => $request->input('number_of_seats'),
            'fuel_type_id' => $request->input('fuel_type'),
        ];

        $identifier = [
            'item_id' => $id
        ];

        $itemVehicle = ItemVehicle::updateOrCreate($identifier, $data);

        $itemMetaInfo = $this->getModuleInfoValues($itemData->module, $itemData->id);
        $metaData = [
            'itemMetaInfo' => $itemMetaInfo ?? NULL,
        ];
        $this->addOrUpdateItemMeta($itemData->id, $metaData);

        $this->updateStepCompleted($itemData->id, 'basic', true);
    }


    public function getVehicleType(Request $request)
    {

        $vehicleModelData = SubCategory::where('make_id', $request->make)->get();

        return response()->json($vehicleModelData);
    }

    public function getVehicleMake(Request $request)
    {
        $typeId  = $request->input('typeId');
        $query = Category::where('module', 2);


        if ($typeId) {
            $query->whereHas('categoryTypeRelations', function ($q) use ($typeId) {
                $q->where('type_id', $typeId);
            });
        }

        $vehicleMakeDataAll = $query->get();

        return response()->json($vehicleMakeDataAll);
    }
}
