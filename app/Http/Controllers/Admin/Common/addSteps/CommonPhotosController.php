<?php

namespace App\Http\Controllers\Admin\Common\addSteps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\CommonModuleItemTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\BookingAvailableTrait;
use App\Models\Modern\{Item};
class CommonPhotosController extends Controller
{
  
    use MediaUploadingTrait,BookingAvailableTrait,CommonModuleItemTrait;

    public function photos(Request $request, $id)
    {
        
        $itemData = Item::where('id',$id)->first();
       
         $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
         $module = $this->getTheModule($realRoute);
         $permissionrealRoute = str_replace("-","_",$realRoute );
         $slug = $this->getTheModuleTitle($realRoute);

        $itemData = Item::findOrFail($id);
        $backButtonRoute = "admin.".$realRoute.".features";
        $updatePhoto = "admin.photos-Update";
        $nextButton = "/admin/".$realRoute."/pricing/";
        $storeMedia ="admin.storeMedia";
        $leftSideMenu = $this->getLeftSideMenu($module);
        return view('admin.common.addSteps.photo.photos',compact('id','itemData','backButtonRoute','updatePhoto','nextButton','storeMedia','leftSideMenu'));

    }
    public function photosUpdate(Request $request)
    {
        $this->CommonPhotosUpdate($request);

    }





}
