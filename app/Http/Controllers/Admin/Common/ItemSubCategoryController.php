<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\{CommonModuleItemTrait};
use App\Models\{SubCategory,Category};
use Illuminate\Support\Facades\Route;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemSubCategoryController extends Controller
{
    use MediaUploadingTrait, CommonModuleItemTrait;


    public function index(Request $request)
{
    $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
    $module = $this->getTheModule($realRoute);
    $permissionrealRoute = str_replace("-", "_", $realRoute);

    abort_if(Gate::denies($permissionrealRoute . '_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = SubCategory::query()
            ->select(sprintf('%s.*', (new SubCategory)->getTable()))
            ->with(['make', 'media']) 
            ->where('module', $module);

        if ($request->filled('Category')) {
            $query->where('make_id', $request->input('Category'));
        }

        return Datatables::of($query)
            ->addColumn('placeholder', '&nbsp;')
            ->addColumn('actions', function ($row) use ($permissionrealRoute, $realRoute) {
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
            })
            ->editColumn('id', fn($row) => $row->id ?? '')
            ->editColumn('name', fn($row) => $row->name ?? '')
            ->editColumn('make_name', fn($row) => $row->make->make_name ?? 'null')
            ->editColumn('description', fn($row) => $row->description ?? '')
           
            ->editColumn('image', function ($row) {
                if ($photo = $row->getFirstMedia('image')) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->getUrl(),
                        $photo->getUrl('thumb')
                    );
                }
                return '';
            })
             ->editColumn('status', fn($row) => $row->status ? SubCategory::STATUS_SELECT[$row->status] : '')
            ->rawColumns(['actions', 'placeholder', 'image'])
            ->make(true);
    }

    $createRoute = "admin." . $realRoute . ".create";
    $indexRoute = "admin." . $realRoute . ".index";
    $ajaxUpdate = "/admin/update-" . $realRoute . "-status";
    $title = $this->getTheModuleTitle($realRoute);

    $categories = Category::where('module', $module)->get();

    return view('admin.common.subCategory.index', compact(
        'createRoute',
        'ajaxUpdate',
        'title',
        'indexRoute',
        'permissionrealRoute',
        'categories',
        'realRoute'
    ));
}

    
    public function create()
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module = $this->getTheModule($realRoute);
        $mainCategory = Category::where('module',$module)
        ->where('status',1)
        ->orderBy('name', 'asc')
        ->get();
        $storeRoute =  "admin.".$realRoute.".store";
        $storeMediaRoute =  "admin.".$realRoute.".storeMedia";
        $storeCKEditorImageRoute =  "admin.".$realRoute.".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);

        return view('admin.common.subCategory.create',compact('module','mainCategory','storeRoute','storeMediaRoute','storeCKEditorImageRoute','title','permissionrealRoute'));
    }

    public function store(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCategoryData = SubCategory::create($request->all());

        if ($request->input('image', false)) {
            $subCategoryData->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $subCategoryData->id]);
        }

        return redirect()->route('admin.'.$realRoute .'.index');
    }

    public function edit($subCatID)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module = $this->getTheModule($realRoute);
        $mainCategory = Category::where('module',$module)
        ->where('status',1)
        ->orderBy('name', 'asc')
        ->get();

        $subCatData  = SubCategory::where('id',$subCatID) ->where('status',1)->first();
        $updateRoute =  "admin.".$realRoute.".update";
        $storeMediaRoute =  "admin.".$realRoute.".storeMedia";
        $storeCKEditorImageRoute =  "admin.".$realRoute.".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);

        return view('admin.common.subCategory.edit', compact('subCatData','mainCategory','updateRoute','storeMediaRoute','storeCKEditorImageRoute','title'));
    }

    public function update(Request $request, $subCatID)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $SubCategoryData  = SubCategory::where('id',$subCatID)->first();
        $SubCategoryData->update($request->all());

        if ($request->input('image', false)) {
            if (! $SubCategoryData->image || $request->input('image') !== $SubCategoryData->image->file_name) {
                if ($SubCategoryData->image) {
                    $SubCategoryData->image->delete();
                }
                $SubCategoryData->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($SubCategoryData->image) {
            $SubCategoryData->image->delete();
        }

        return redirect()->route('admin.'.$realRoute.'.index');
    }

    public function show($subCatID)
    {

        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $indexRoute =  "admin.".$realRoute.".index";
        $title = $this->getTheModuleTitle($realRoute);
        $categoryData  = SubCategory::where('id',$subCatID)->with('make')->first();
      
   
        return view('admin.common.subCategory.show', compact('categoryData','indexRoute','title'));
    }

    public function storeCKEditorImages(Request $request)
    {
       $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );

        abort_if(Gate::denies($permissionrealRoute.'_create') && Gate::denies($permissionrealRoute.'_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sunCatData         = new SubCategory();
        $sunCatData->id     = $request->input('crud_id', 0);
        $sunCatData->exists = true;
        $media         = $sunCatData->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function updateStatus(Request $request){
       
        if (Gate::denies('vehicle_model_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }

        $product_status = SubCategory::where('id', $request->pid)->update(['status' => $request->status,]);
        if ($product_status) {
            return response()->json([
                'ststus' => 200,
                'message' => trans('global.status_updated_successfully')
            ]);
        } else {
            return response()->json([
                'ststus' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }

    }
    public function destroy($subCatID)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies( $permissionrealRoute.'_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $VehicleMake = SubCategory::find($subCatID);

        $VehicleMake->delete();

        return back();
    }


    public function vehicleModelDelete(Request $request)
    {
        abort_if(Gate::denies('vehicle_model_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->input('ids');

        if (!empty($ids)) {
            try {
                // SubCategory::whereIn('id', $ids)->delete();
                $subCategory = SubCategory::whereIn('id', $ids)->get();
    
                foreach ($subCategory as $category) {
                   
                    if ($category->image) {
                        $category->image->delete();
                    }
    
                    
                    $category->clearMediaCollection('image');
                    
                   
                    $category->forceDelete();
                }
    
                return response()->json(['message' => trans('global.successfully_deleted')], Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json(['message' => trans('global.something_wrong')], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        return response()->json(['message' => trans('global.no_entries_selected')], Response::HTTP_BAD_REQUEST);
    }

}
