<?php

namespace App\Http\Controllers\Admin\Common\addSteps;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\CommonModuleItemTrait;
use App\Models\{CancellationPolicy};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\BookingAvailableTrait;
use App\Models\Modern\{Item,ItemMeta};
class CommonCancellationPoliciesController extends Controller
{
  
    use MediaUploadingTrait,BookingAvailableTrait,CommonModuleItemTrait;

    public function CancellationPolicies(Request $request, $id)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $module = $this->getTheModule($realRoute);
        $cancellationPolicyData = CancellationPolicy::where('module',$module)->get();
        $rules = ItemMeta::where('rental_item_id',$id)->where('meta_key','rules')->first();
        $policy = Item::where('id',$id)->first();
        $serviceType = $policy->service_type; 
   
        $permissionrealRoute = str_replace("-","_",$realRoute );
        $slug = $this->getTheModuleTitle($realRoute);
        
        $itemRules = $this->getItemRule($policy->module);
        $backButtonRoute = "admin.".$realRoute.".pricing";
        $updatePolicyRoute = "admin.cancellation-policies-Update";
        $nextButton = "/admin/".$realRoute."/calendar/";
        $leftSideMenu = $this->getLeftSideMenu($module);
        
        return view('admin.common.addSteps.cancellationPolicy.cancellationPolicies',compact('id','cancellationPolicyData', 'serviceType','rules','policy','itemRules','backButtonRoute','updatePolicyRoute','nextButton','leftSideMenu'));
    
    }
    public function cancellationPoliciesUpdate(Request $request)
    {
        $this->CommonCancellationPoliciesUpdate($request);

    }





}
