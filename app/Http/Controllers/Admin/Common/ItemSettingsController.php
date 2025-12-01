<?php

namespace App\Http\Controllers\Admin\Common;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\{CommonModuleItemTrait};
use App\Models\{GeneralSetting};
use Illuminate\Support\Facades\Route;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemSettingsController extends Controller
{
  
    use MediaUploadingTrait,CommonModuleItemTrait;

   
    public function generalform()
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $module = $this->getTheModule($realRoute);
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies( $permissionrealRoute.'_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $title = GeneralSetting::where('meta_key', 'title')->where('module',$module)->first();
        $head_title = GeneralSetting::where('meta_key', 'head_title')->where('module',$module)->first();
        $image_text = GeneralSetting::where('meta_key', 'image_text')->where('module',$module)->first();
        $item_setting_image = GeneralSetting::where('meta_key', 'item_setting_image')->where('module',$module)->first();
        
        $updateSetting = 'admin.'.$realRoute.'.addConfigurationWizard';
        $mainHeadingTitle = $this->getTheModuleTitle($realRoute);

        return view('admin.common.settings.BasicConfigurationForm', compact('title', 'head_title', 'image_text', 'item_setting_image','module','updateSetting','mainHeadingTitle'));
    }

    public function addConfigurationWizard(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $module = $this->getTheModule($realRoute);
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies( $permissionrealRoute.'_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->CommanAddConfigurationWizard($request);
        return redirect()->route('admin.'.$realRoute.'.generalform');

    }
    

}
