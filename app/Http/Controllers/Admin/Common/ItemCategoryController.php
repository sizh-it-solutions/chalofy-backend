<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{MediaUploadingTrait, CommonModuleItemTrait};
use App\Models\{SubCategory, Category, CategoryTypeRelation};
use App\Models\Modern\{ItemType};
use Illuminate\Support\Facades\Route;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemCategoryController extends Controller
{
    use MediaUploadingTrait, CommonModuleItemTrait;

    public function index(Request $request)
{
    $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
    $module = $this->getTheModule($realRoute);
    $permissionrealRoute = str_replace("-", "_", $realRoute);
    abort_if(Gate::denies($permissionrealRoute . '_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $typeId = $request->input('typeId');

    if ($request->ajax()) {
        $query = Category::with(['media', 'categoryTypeRelations.ItemType']) // eager load for N+1 prevention
            ->select(sprintf('%s.*', (new Category)->table))
            ->where('module', $module);

        if ($request->filled('typeId')) {
            $query->whereHas('categoryTypeRelations', function ($q) use ($typeId) {
                $q->where('type_id', $typeId);
            });
        }

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
        $table->editColumn('make_name', fn($row) => $row->make_name ?: '');
        $table->editColumn('description', fn($row) => $row->description ?: '');

       
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

        $table->editColumn('typeName', function ($row) {
            $typeNames = $row->categoryTypeRelations->pluck('ItemType.name')->filter()->toArray();
            return implode(', ', $typeNames);
        });
 $table->editColumn('status', function ($row) {
            return $row->status ? Category::STATUS_SELECT[$row->status] : '';
        });

        $table->rawColumns(['actions', 'placeholder', 'image']);

        return $table->make(true);
    }

    $createRoute = "admin." . $realRoute . ".create";
    $indexRoute = "admin." . $realRoute . ".index";
    $ajaxUpdate = "/admin/update-" . $realRoute . "-status";
    $title = $this->getTheModuleTitle($realRoute);
    $types = ItemType::with(['media'])->where('module', $module)->get();

    return view('admin.common.category.index', compact(
        'createRoute',
        'ajaxUpdate',
        'title',
        'indexRoute',
        'permissionrealRoute',
        'types'
    ));
}

    public function create()
    {

        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);
        abort_if(Gate::denies($permissionrealRoute . '_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module = $this->getTheModule($realRoute);
        $storeRoute =  "admin." . $realRoute . ".store";
        $storeMediaRoute =  "admin." . $realRoute . ".storeMedia";
        $storeCKEditorImageRoute =  "admin." . $realRoute . ".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);

        $itemTypes = ItemType::all();
        return view('admin.common.category.create', compact('module', 'storeRoute', 'storeMediaRoute', 'storeCKEditorImageRoute', 'title', 'permissionrealRoute', 'itemTypes'));
    }

    public function store(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);
        abort_if(Gate::denies($permissionrealRoute . '_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catData = Category::create($request->all());

        if ($request->input('image', false)) {
            $catData->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $catData->id]);
        }
        $itemTypeId = $request->input('item_type');
        $categoryId = $catData->id;

        $itemTypes = $request->input('item_types');
        foreach ($itemTypes as $typeId) {
            CategoryTypeRelation::create([
                'category_id' =>  $categoryId,
                'type_id' => $typeId,
            ]);
        }

        return redirect()->route('admin.' . $realRoute . '.index');
    }

    public function edit($catID)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);
        abort_if(Gate::denies($permissionrealRoute . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catIData  = Category::where('id', $catID)->first();
        $updateRoute =  "admin." . $realRoute . ".update";
        $storeMediaRoute =  "admin." . $realRoute . ".storeMedia";
        $storeCKEditorImageRoute =  "admin." . $realRoute . ".storeCKEditorImages";
        $title = $this->getTheModuleTitle($realRoute);

        $itemTypes = ItemType::all();
        $categoryTypeRelation = CategoryTypeRelation::where('category_id', $catID)->first();


        $selectedItemTypes = CategoryTypeRelation::where('category_id', $catID)->pluck('type_id')->toArray();

        return view('admin.common.category.edit', compact('catIData', 'updateRoute', 'storeMediaRoute', 'storeCKEditorImageRoute', 'title', 'itemTypes', 'selectedItemTypes'));
    }

    public function update(Request $request, $catID)
    {

        $categoryData  = Category::where('id', $catID)->first();
        $categoryData->update($request->all());
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        if ($request->input('image', false)) {
            if (! $categoryData->image || $request->input('image') !== $categoryData->image->file_name) {
                if ($categoryData->image) {
                    $categoryData->image->delete();
                }
                $categoryData->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($categoryData->image) {
            $categoryData->image->delete();
        }

        $itemTypeIds = $request->input('item_types', []);
        $currentTypeIds = CategoryTypeRelation::where('category_id', $catID)->pluck('type_id')->toArray();

        // Find item types to add
        $typesToAdd = array_diff($itemTypeIds, $currentTypeIds);
        foreach ($typesToAdd as $typeId) {
            CategoryTypeRelation::updateOrCreate([
                'category_id' => $catID,
                'type_id' => $typeId,
            ]);
        }

        // Find item types to remove
        $typesToRemove = array_diff($currentTypeIds, $itemTypeIds);
        CategoryTypeRelation::where('category_id', $catID)->whereIn('type_id', $typesToRemove)->delete();
        return redirect()->route('admin.' . $realRoute . '.index');
    }

    public function show($itemType)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);
        abort_if(Gate::denies($permissionrealRoute . '_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $indexRoute =  "admin." . $realRoute . ".index";
        $categoryData  = Category::where('id', $itemType)->first();
        $title = $this->getTheModuleTitle($realRoute);

        return view('admin.common.category.show', compact('categoryData', 'indexRoute', 'title'));
    }

    public function storeCKEditorImages(Request $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);

        abort_if(Gate::denies($permissionrealRoute . '_create') && Gate::denies($permissionrealRoute . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Category();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function updateStatus(Request $request)
    {
        if (Gate::denies('vehicle_makes_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }

        $product_status = Category::where('id', $request->pid)->update(['status' => $request->status,]);
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


    public function destroy($catID)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $permissionrealRoute = str_replace("-", "_", $realRoute);
        abort_if(Gate::denies($permissionrealRoute . '_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catData = Category::find($catID);

        if ($catData) {
            try {
                // Delete related SubCategory entries
                $subCats = SubCategory::where('make_id', $catID)->get();

                if ($subCats->isNotEmpty()) {
                    foreach ($subCats as $subCat) {
                        
                        if ($subCat) {
                            $subCat->delete(); 
                        }
                    }
                }
                $catTypeRelations = $catData->categoryTypeRelations; 

                if ($catTypeRelations->isNotEmpty()) {
                    foreach ($catTypeRelations as $relation) {
                        $relation->delete(); 
                    }
                }

                $catData->delete();

                return back()->with('message', trans('global.the_record_has_been_deleted'));
            } catch (\Exception $e) {
                return back()->with('error', trans('global.something_wrong'));
            }
        }

        return back()->with('error', trans('global.no_entries_selected'));
    }



    public function vehicleDelete(Request $request)
    {
        abort_if(Gate::denies('vehicle_makes_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->input('ids');

        if (!empty($ids)) {
            try {
                foreach ($ids as $id) {

                    SubCategory::where('make_id', $id)->delete();

                    CategoryTypeRelation::whereIn('category_id', $ids)->delete();

                    Category::find($id)->delete();
                }

                return response()->json(['message' => trans('global.the_record_has_been_deleted')], 200);
            } catch (Exception $e) {
                return response()->json(['message' => trans('global.something_wrong')], 500);
            }
        }

        return response()->json(['message' => trans('global.no_entries_selected')], 400);
    }
}
