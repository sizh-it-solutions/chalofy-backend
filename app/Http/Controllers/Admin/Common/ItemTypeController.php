<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\{CommonModuleItemTrait};
use App\Models\Modern\{ItemType};
use Illuminate\Support\Facades\Route;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemTypeController extends Controller
{
    use MediaUploadingTrait, CommonModuleItemTrait;

   public function index(Request $request)
{
    $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
    $module = $this->getTheModule($realRoute);
    $permissionrealRoute = str_replace("-", "_", $realRoute);
    abort_if(Gate::denies($permissionrealRoute . '_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = ItemType::with('media') // eager load to resolve N+1
            ->select(sprintf('%s.*', (new ItemType)->table))
            ->where('module', $module);

        $table = Datatables::of($query);

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

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
        $table->editColumn('description', fn($row) => $row->description ?: '');

        $table->editColumn('status', function ($row) {
            return $row->status ? ItemType::STATUS_SELECT[$row->status] : '';
        });

        $table->editColumn('image', function ($row) {
            if ($photo = $row->image) {
                return sprintf(
                    '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                    $photo->url,
                    $photo->thumbnail
                );
            }
            return '';
        });

        $table->rawColumns(['actions', 'placeholder', 'image']);

        return $table->make(true);
    }

    $createRoute = "admin." . $realRoute . ".create";
    $indexRoute = "admin." . $realRoute . ".index";
    $ajaxUpdate = "/admin/update-" . $realRoute . "-status";
    $title = $this->getTheModuleTitle($realRoute);

    return view('admin.common.type.index', compact('createRoute', 'ajaxUpdate', 'title', 'indexRoute', 'permissionrealRoute'));
}


    public function create()
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module = $this->getTheModule($realRoute);

        $storeRoute =  "admin.".$realRoute.".store";
        $storeMediaRoute =  "admin.".$realRoute.".storeMedia";
        $storeCKEditorImageRoute =  "admin.".$realRoute.".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);
        return view('admin.common.type.create',compact('storeRoute','storeMediaRoute','storeCKEditorImageRoute','module','title','permissionrealRoute'));
       
    }

    public function store(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ItemType = ItemType::create($request->all());
     
        if ($request->input('image', false)) {
            $ItemType->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ItemType->id]);
        }

        return redirect()->route('admin.'.$realRoute .'.index');
    }

    public function edit($itemType)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ItemType = ItemType::where('id',$itemType)->first();
        $updateRoute =  "admin.".$realRoute.".update";
        $storeMediaRoute =  "admin.".$realRoute.".storeMedia";
        $storeCKEditorImageRoute =  "admin.".$realRoute.".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);
        return view('admin.common.type.edit', compact('ItemType','updateRoute','storeMediaRoute','storeCKEditorImageRoute','title'));

    }
 
    public function update(Request $request, $itemType)
    {
        $ItemType = ItemType::where('id',$itemType)->first();
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $ItemType->update($request->all());

        if ($request->input('image', false)) {
            if (! $ItemType->image || $request->input('image') !== $ItemType->image->file_name) {
                if ($ItemType->image) {
                    $ItemType->image->delete();
                }
                $ItemType->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($ItemType->image) {
            $ItemType->image->delete();
        }

        return redirect()->route('admin.'.$realRoute.'.index');
    }

    public function show($ItemType)
    {
        $itemType = ItemType::where('id',$ItemType)->first();
        
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies($permissionrealRoute.'_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $indexRoute =  "admin.".$realRoute.".index";

        $title = $this->getTheModuleTitle($realRoute);

        return view('admin.common.type.show', compact('itemType','indexRoute','title'));
   
    }
 public function destroy( $itemType)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );
        abort_if(Gate::denies( $permissionrealRoute.'_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $itemType = ItemType::find($itemType);
        //$ItemType->delete();
        $itemType->deleteItemType();
    

        return back();
    }
    public function storeCKEditorImages(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-","_",$realRoute );

        abort_if(Gate::denies($permissionrealRoute.'_create') && Gate::denies($permissionrealRoute.'_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ItemType();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function updateStatus(Request $request){
        if (Gate::denies('vehicle_type_edit')) {  
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }
        $product_status = ItemType::where('id', $request->pid)->update(['status' => $request->status,]);
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

    public function bulkDelete(Request $request)
    {
        abort_if(Gate::denies('vehicle_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->input('ids');
    
        if (!empty($ids)) {
            try {
                $deletedCount = 0;
    
                foreach ($ids as $id) {
                    $item = ItemType::findOrFail($id);
    
                    // Delete associated media (image and gallery)
                    if ($item->image) {
                        $item->image->delete();
                        $item->clearMediaCollection('image');
                    }
    
                    if ($item->gallery) {
                        $item->gallery->each(function (Media $media) {
                            $media->delete();
                        });
                        $item->clearMediaCollection('image');
                    }
    
                    // Delete the item
                    $item->forceDelete();
                    $deletedCount++;
                }
    
                return response()->json(['message' => trans('global.successfully_deleted', ['count' => $deletedCount])], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => trans('global.something_wrong')], 500);
            }
        }
    
        return response()->json(['message' => trans('global.no_entries_selected')], 400);
    }
     public function typeSearch(Request $request)
    {
        $searchTerm = $request->input('q', '');
        $page = (int) $request->input('page', 1);
        $perPage = 20;
        $query = ItemType::query();

        if ($searchTerm !== '') {
            $query->where('name', 'like', "%{$searchTerm}%");
        }
        $types = $query
            ->orderBy('name')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $results = $types->map(function ($type) {
            return [
                'id' => $type->id,
                'text' => $type->name,
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $types->count() === $perPage,
            ],
        ]);
    }
}
