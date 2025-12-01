<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCancellationpolicyRequest;
use App\Http\Requests\UpdateCancellationpolicy;
use App\Models\{CancellationPolicy, Module};
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CancellationPolicies extends Controller
{
    public function index(Request $request)
    {
        $module = Module::where('default_module', '1')->first();
        $moduleId = $module->id;
        $moduleName = $module->name;
        $policydata = CancellationPolicy::orderby('id','desc')->where('module',$moduleId)->get();
        return view('admin.cancellationPolicy.index',compact('policydata','moduleName'));
    }
    public function create(Request $request)
    {
        $module = Module::All();
        return view('admin.cancellationPolicy.create',compact('module'));
    }
    public function store(StoreCancellationpolicyRequest $request)
    {
         $Data = CancellationPolicy::create($request->all());
    
        return redirect()->route('admin.cancellation-policies.index');
    }
    public function edit(Request $request, $id)
    {
        $cancellationdata = CancellationPolicy::where('id',$id)->first();
        $modules = Module::all();
        return view('admin.cancellationPolicy.edit',compact('cancellationdata','modules'));
    }

    public function update(UpdateCancellationpolicy $request, CancellationPolicy $id)
    {
        
        $id->update($request->all());

        return redirect()->route('admin.cancellation-policies.index');
    }
    public function delete($id){
       
        $policy = CancellationPolicy::find($id);
        
            if (!$policy) {
                return redirect()->route('admin.cancellation-policies.index')->with('error', 'Review not found');
            }
            $policy->delete();
            return redirect()->route('admin.cancellation-policies.index');
    }
    public function updateStatus(Request $request){
        if(Gate::denies('cancellation_policies_edit'))
        {
         return response()->json(['message' => "You don't have permission to perform this action."]);
        }

        $statusData = CancellationPolicy::where('id', $request->pid)->update(['status' => $request->status,]);
        if ($statusData) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.status_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }

    }


    public function deleteAll(Request $request) {
        abort_if(Gate::denies('cancellation_policies_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->input('ids');
        if (!empty($ids)) {
            try {

                CancellationPolicy::whereIn('id', $ids)->delete();
                return response()->json(['message' => 'Items deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['message' => 'No entries selected'], 400);
    }
}
