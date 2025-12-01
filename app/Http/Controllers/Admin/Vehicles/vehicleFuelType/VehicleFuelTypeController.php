<?php

namespace App\Http\Controllers\Admin\Vehicles\VehicleFuelType;

use App\Http\Controllers\Controller;
use App\Models\VehicleFuelType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;
use App\Constants\DateFormat;
class VehicleFuelTypeController extends Controller
{
   public function index(Request $request)
{
    $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
    $permissionrealRoute = str_replace("-", "_", $realRoute);
    // abort_if(Gate::denies($permissionrealRoute . '_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = VehicleFuelType::orderBy('id', 'desc');
        $table = DataTables::of($query)
            ->addColumn('placeholder', '&nbsp;')
            ->addColumn('actions', '&nbsp;');
        $table->editColumn('actions', function ($row) use ($permissionrealRoute, $realRoute) {
            $viewGate = '';
            $editGate = $permissionrealRoute . '_edit';
            $deleteGate = $permissionrealRoute . '_delete';
            $crudRoutePart = $realRoute;
            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        $table->editColumn('id', fn($row) => $row->id ?: '');
        $table->editColumn('name', fn($row) => $row->name ?: '');
        $table->editColumn('created_at', fn($row) => $row->created_at ? DateFormat::format($row->created_at) : '');
        $table->editColumn('status', fn($row) => $row->status ? VehicleFuelType::STATUS_SELECT[$row->status] : '');
        $table->rawColumns(['actions', 'placeholder']);
        return $table->make(true);
    }

    $createRoute = "admin." . $realRoute . ".create";
    $indexRoute = "admin." . $realRoute . ".index";
    $ajaxUpdate = "/admin/update-fuel-type-status";
    $title = "Vehicle Fuel Type";

    return view('admin.vehicles.vehicle-fuel-type.index', compact(
        'createRoute',
        'ajaxUpdate',
        'title',
        'indexRoute',
        'permissionrealRoute'
    ));
}


    public function create()
    {
        $moduleId = 2;
        return view('admin.vehicles.vehicle-fuel-type.create', compact('moduleId'));
    }

    public function store(Request $request)
    {
        $vehicleFuelType = VehicleFuelType::create($request->all());
        return redirect()->route('admin.vehicle-fuel-type.index');
    }

    public function edit($vehicleFuelType)
    {
        $fuelTypeData = VehicleFuelType::where('id', $vehicleFuelType)->first();
        return view('admin.vehicles.vehicle-fuel-type.edit', compact('fuelTypeData', 'vehicleFuelType'));
    }

    public function update(Request $request, $fuelTypeId)
    {
        $fuelType = VehicleFuelType::where('id', $fuelTypeId)->first();
        $fuelType->update($request->all());
        return redirect()->route('admin.vehicle-fuel-type.index');
    }

    public function show($fuelTypeId)
    {
        $fuelTypeData = VehicleFuelType::where('id', $fuelTypeId)->first();
        return view('admin.vehicles.vehicle-fuel-type.show', compact('fuelTypeData'));
    }

    public function updateFuelTypeStatus(Request $request)
    {
        if (Gate::denies('vehicle_fuel_type_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }

        $statusUpdate = VehicleFuelType::where('id', $request->pid)->update(['status' => $request->status]);
        if ($statusUpdate) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.status_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }
public function destroy($id)
{
    $fuelType = VehicleFuelType::findOrFail($id);
    $fuelType->delete();

    return redirect()->back()->with('success', 'Fuel type deleted successfully.');
}

   

    public function deleteAll(Request $request)
    {
        abort_if(Gate::denies('vehicle_fuel_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ids = $request->input('ids');
        if (!empty($ids)) {
            try {
                VehicleFuelType::whereIn('id', $ids)->delete();
                return response()->json(['message' => 'Items deleted successfully'], 200);
            } catch (\Exception $e) {
                \Log::error('Deletion error: ' . $e->getMessage());
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['message' => 'No entries selected'], 400);
    }
}
