<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\{CommonModuleItemTrait, ItemControlTrait, NotificationTrait};
use App\Models\Modern\{ItemFeatures};
use App\Http\Requests\StoreItemRequest;
use Illuminate\Support\Facades\Route;
use App\Models\{AppUser, Module, GeneralSetting, City};
use App\Models\Modern\{Item, ItemMeta, ItemType};
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    use MediaUploadingTrait, CommonModuleItemTrait, ItemControlTrait, NotificationTrait;

    public function index()
    {

        abort_if(Gate::denies('item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $module = $this->getTheModule($realRoute);
        $filters = [
            'from' => request()->input('from'),
            'to' => request()->input('to'),
            'status' => request()->input('status'),
            'title' => request()->input('title'),
            'vendor' => request()->input('vendor'),
            'type' => request()->input('type'),
            'step_progress_range' => request()->input('step_progress_range'),
        ];

        if (\Route::currentRouteName() === 'admin.vehicles.trash') {
            $query = Item::onlyTrashed()->where('module', $module)->orderBy('id', 'desc')->with(['userid', 'item_Type', 'features', 'place', 'media']);
        } else {
            $query = Item::where('module', $module)
                ->orderBy('id', 'desc')
                ->with(['userid', 'item_type', 'features', 'place', 'media']);
        }


        $statusCounts = Item::selectRaw('
            COUNT(*) as live,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive,
            SUM(CASE WHEN is_verified = 1 THEN 1 ELSE 0 END) as verified,
            SUM(CASE WHEN is_featured = 1 THEN 1 ELSE 0 END) as featured
        ')
            ->where('module', $module)
            ->first();

        $statusCounts = [
            'live' => $statusCounts->live,
            'active' => $statusCounts->active,
            'inactive' => $statusCounts->inactive,
            'verified' => $statusCounts->verified,
            'featured' => $statusCounts->featured,
            'trash' => Item::onlyTrashed()->where('module', $module)->count(),
        ];

        // Apply filters
        $isFiltered = array_filter($filters, fn($value) => !is_null($value) && $value !== '');

        if ($filters['from'] || $filters['to']) {
            $from = $filters['from'] ? date('Y-m-d 00:00:00', strtotime($filters['from'])) : null;
            $to = $filters['to'] ? date('Y-m-d 23:59:59', strtotime($filters['to'])) : null;

            if ($from && $to) {
                $query->whereBetween('created_at', [$from, $to]);
            } elseif ($from) {
                $query->where('created_at', '>=', $from);
            } elseif ($to) {
                $query->where('created_at', '<=', $to);
            }
        }

        if (!is_null($filters['status'])) {
            $statusMap = [
                'active' => ['status', 1],
                'inactive' => ['status', 0],
                'verified' => ['is_verified', 1],
                'featured' => ['is_featured', 1],
            ];

            if (isset($statusMap[$filters['status']])) {
                [$column, $value] = $statusMap[$filters['status']];
                $query->where($column, $value);
            }
        }

        if ($filters['title']) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if ($filters['vendor']) {
            $query->where('userid_id', $filters['vendor']);
        }

        if ($filters['type']) {
            $query->whereHas('item_type', fn($q) => $q->where('id', $filters['type']));
        }

        if ($filters['step_progress_range']) {
            [$start, $end] = explode('-', $filters['step_progress_range']);
            $query->whereBetween('step_progress', [(float) $start, (float) $end]);
        }

        $items = $query->paginate(50);
        $items->appends(array_filter($filters, fn($value) => !is_null($value) && $value !== ''));

        $relatedData = [
            'item' => $filters['title'] ? Item::select('id', 'title')->find($filters['title']) : null,
            'vendor' => $filters['vendor'] ? AppUser::select('id', 'first_name', 'last_name', 'phone')->find($filters['vendor']) : null,
            'type' => $filters['type'] ? ItemType::select('id', 'name')->find($filters['type']) : null,
        ];

        $searchfield = $relatedData['item'] ? $relatedData['item']->title : 'All';
          $searchfieldItemId = $relatedData['item'] ? $relatedData['item']->id : '';
        $vendorname = $relatedData['vendor'] ? "{$relatedData['vendor']->first_name} {$relatedData['vendor']->last_name} ({$relatedData['vendor']->phone})" : 'All';
        $vendorId = $relatedData['vendor'] ? $relatedData['vendor']->id : '';
        $typeName = $relatedData['type'] ? $relatedData['type']->name : 'All';
        $typeId = $relatedData['type'] ? $relatedData['type']->id : '';

        $permissionrealRoute = str_replace("-", "_", $realRoute);
        $trashRoute = "admin.{$realRoute}.trash";
        $indexRoute = "admin.{$realRoute}.index";
        $title = $this->getTheModuleTitle($realRoute);

        return view('admin.common.index', compact(
            'title',
            'realRoute',
            'statusCounts',
            'trashRoute',
            'indexRoute',
            'items',
            'searchfield',
            'filters',
            'vendorId',
            'vendorname',
            'typeName',
            'typeId',
            'searchfieldItemId'
        ));
    }

    public function create()
    {


        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $title = $this->getTheModuleTitle($realRoute);

        $module = $this->getTheModule($realRoute);


        $userids = AppUser::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $item_types = ItemType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $features = ItemFeatures::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $places = City::where('module', $module)->where('status', '1')->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $supportedLocales = ['en' => 'English'];

      

         
        return view('admin.common.create', compact('title', 'realRoute', 'features', 'places', 'item_types', 'userids', 'module','supportedLocales'));
    }

public function store(Request $request)
{
    $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
    $title = $this->getTheModuleTitle($realRoute);
    $module = $this->getTheModule($realRoute);

    $selectedfeatures = implode(',', $request->input('features_id', []));

    $steps = [
        'basic' => false,
        'title' => false,
        'location' => false,
        'features' => false,
        'price' => false,
        'policies' => false,
        'photos' => false,
        'document' => false,
        'calendar' => false
    ];
    $stepJson = json_encode($steps);

    // Extract English title and description for the main item table
    $englishTitle = $request->input('title.en', '');
    $englishDescription = $request->input('description.en', '');

    // Create the item record with EN fields
    $item = Item::create([
        'title' => $englishTitle,
        'description' => $englishDescription,
        'userid_id' => $request->userid_id,
        'place_id' => $request->place_id,
        'features' => $selectedfeatures,
        'steps_completed' => $stepJson,
        'module' => $module,
    ]);

    $newitemId = $item->id;

    // Insert translations for other locales only
    foreach ($request->title as $locale => $titleValue) {
        if ($locale != 'en' && !empty($titleValue)) {
            DB::table('translations')->insert([
                'translatable_id' => $newitemId,
                'translatable_type' => Item::class,
                'locale' => $locale,
                'key' => 'title',
                'value' => $titleValue,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    foreach ($request->description as $locale => $descriptionValue) {
        if ($locale != 'en' && !empty($descriptionValue)) {
            DB::table('translations')->insert([
                'translatable_id' => $newitemId,
                'translatable_type' => Item::class,
                'locale' => $locale,
                'key' => 'description',
                'value' => $descriptionValue,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    $this->updateStepCompleted($newitemId, 'title', true);

    return redirect()->to(url('admin/' . $realRoute . '/base') . '/' . $newitemId);
}

    public function store_old(StoreItemRequest $request)
    {
        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $title = $this->getTheModuleTitle($realRoute);

        $module = $this->getTheModule($realRoute);
        $selectedfeatures = implode(',', $request->input('features_id', []));
        $steps = [
            'basic' => false,
            'title' => false,
            'location' => false,
            'features' => false,
            'price' => false,
            'policies' => false,
            'photos' => false,
            'document' => false,
            'calendar' => false
        ];
        $stepJson = json_encode($steps);
        ;
        $item = Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'userid_id' => $request->userid_id,
            'place_id' => $request->place_id,
            'features' => $selectedfeatures,
            'steps_completed' => $stepJson,
            'module' => $module, // Ensure the module is stored correctly
        ]);
        $newitemId = $item->id;

        $this->updateStepCompleted($item->id, 'title', true);

        return redirect()->to(url('admin/' . $realRoute . '/base') . '/' . $newitemId);
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden'); //

        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }





    public function trashListings(Request $request)
    {

        abort_if(Gate::denies('item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $realRoute = explode('.', Route::currentRouteName())[1] ?? null;
        $module = $this->getTheModule($realRoute);
        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');
        $items_title = request()->input('title');
        $customer = request()->input('customer');
        $query = Item::onlyTrashed()->where('module', $module)->orderBy('id', 'desc')->with(['userid', 'item_Type', 'features', 'place', 'media']);

        $statusCounts = [
            'live' => Item::where('module', $module)->count(),
            'active' => Item::where('module', $module)->where('status', 1)->count(),
            'inactive' => Item::where('module', $module)->where('status', 0)->count(),
            'verified' => Item::where('module', $module)->where('is_verified', 1)->count(),
            'featured' => Item::where('module', $module)->where('is_featured', 1)->count(),
            'trash' => Item::onlyTrashed()->where('module', $module)->count(),
        ];


        $isFiltered = ($from || $to || $status || $items_title || $customer);

        if ($from && $to) {
            $query->whereBetween('created_at', [date("Y-m-d", strtotime($from)) . ' 00:00:00', date("Y-m-d", strtotime($to)) . ' 23:59:59']);
        } elseif ($from) {
            $query->where('created_at', '>=', date("Y-m-d", strtotime($from)) . ' 00:00:00');
        } elseif ($to) {
            $query->where('created_at', '<=', date("Y-m-d", strtotime($to)) . ' 23:59:59');
        }

        if ($status !== null) {
            if ($status === 'active') {
                $query->where('status', 1);
            } elseif ($status === 'inactive') {
                $query->where('status', 0);
            } elseif ($status === 'verified') {
                $query->where('is_verified', 1);
            } elseif ($status === 'featured') {
                $query->where('is_featured', 1);
            }
        }

        if ($items_title) {
            $query->where('title', 'like', '%' . $items_title . '%');
        }
        if ($customer) {
            $query->where('userid_id', $customer);
        }

        $items = $isFiltered ? $query->paginate(50) : Item::onlyTrashed()->where('module', $module)->orderBy('id', 'desc')->with(['userid', 'item_Type', 'features', 'place', 'media'])->paginate(50);

        $queryParameters = [];

        if ($from != null) {
            $queryParameters['from'] = $from;
        }
        if ($to != null) {
            $queryParameters['to'] = $to;
        }
        if ($status != null) {
            $queryParameters['status'] = $status;
        }

        if ($items_title != null) {
            $queryParameters['items_title'] = $items_title;
        }
        if ($customer != null) {
            $queryParameters['customer'] = $customer;
        }

        $items->appends($queryParameters);

        $fielddata = request()->input('items_title');
        $fieldname = Item::find($fielddata);
        if ($fieldname) {
            $searchfield = $fieldname->title;
        } else {
            $searchfield = 'All';
        }

        $fieldname = AppUser::find($customer);
        if ($fieldname) {
            $customername = $fieldname->first_name . ' ' . $fieldname->last_name . '(' . $fieldname->phone . ')';
        } else {
            $customername = 'All';
        }

        $general_default_currency = GeneralSetting::where('meta_key', 'general_default_currency')->first();

        $permissionrealRoute = str_replace("-", "_", $realRoute);
        $trashRoute = "admin." . $realRoute . ".trash";
        $indexRoute = "admin." . $realRoute . ".index";
        $title = $this->getTheModuleTitle($realRoute);
        return view('admin.common.trash.trash', compact('title', 'trashRoute', 'realRoute', 'indexRoute', 'items', 'searchfield', 'statusCounts', 'general_default_currency', 'items_title', 'customername', 'module'));
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();

        return;
    }

    public function permanentDelete($id)
    {
        $item = Item::onlyTrashed()->find($id);

        if (!$item) {
            return;
        }

        $module_id = $item->module;

        $moduleName = strtolower(Module::where('id', $module_id)->value('name'));
        abort_if(Gate::denies('item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($item->front_image) {
            $item->front_image->delete();
            $item->clearMediaCollection('front_image');
        }
        if ($item->gallery) {
            $item->gallery->each(function (Media $media) {
                $media->delete();
            });
            $item->clearMediaCollection('gallery');
        }
        ItemMeta::where('rental_item_id', $item->id)->delete();

        $item->forceDelete();

        if (!$moduleName) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        return response()->json(['module_name' => $moduleName], 200);
    }

    public function permanentDeleteAll(Request $request)
    {
        $module_id = $request->input('module');

        abort_if(Gate::denies('item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!$module_id) {
            return response()->json(['error' => 'Module ID is required'], 400);
        }

        $trashedItems = Item::onlyTrashed()->where('module', $module_id)->get();

        foreach ($trashedItems as $item) {

            ItemMeta::where('rental_item_id', $item->id)->delete();
            if ($item->front_image) {
                $item->front_image->delete();
                $item->clearMediaCollection('front_image');
            }

            if ($item->gallery) {
                $item->gallery->each(function (Media $media) {
                    $media->delete();
                });
                $item->clearMediaCollection('gallery');
            }
            $item->forceDelete();
        }

        return response()->json(['success' => 'Selected items permanently deleted']);
    }

    public function deleteRows(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            try {

                Item::whereIn('id', $ids)->delete();
                return response()->json(['message' => 'Items deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['message' => 'No entries selected'], 400);
    }

    public function trashDeleteRows(Request $request)
    {
        $ids = $request->input('ids');



        if (!empty($ids)) {
            try {
                $trashedItems = Item::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($trashedItems as $item) {
                    ItemMeta::where('rental_item_id', $item->id)->delete();
                    if ($item->front_image) {
                        $item->front_image->delete();
                        $item->clearMediaCollection('front_image');
                    }

                    if ($item->gallery) {
                        $item->gallery->each(function (Media $media) {
                            $media->delete();
                        });
                        $item->clearMediaCollection('gallery');
                    }
                    $item->forceDelete();
                }


                return response()->json(['message' => 'Items deleted from trash successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['message' => 'No entries selected'], 400);
    }

    public function searchItem(Request $request)
    {
        $searchTerm = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 20;

        $currentModule = app('currentModule');

        $query = Item::query()->where('module', $currentModule->id);

        if ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $items = $query
            ->select('id', 'title')
            ->orderBy('title')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->id,
                'text' => $item->title,
            ];
        }

        return response()->json([
            'results' => $data,
            'pagination' => ['more' => $items->count() === $perPage]
        ]);
    }


    public function updateStatus(Request $request)
    {
        if (Gate::denies('vehicle_edit')) {
            return response()->json([
                'message' => "You don't have permission to perform this action."
            ]);
        }

        $item = Item::find($request->pid);

        $steps = json_decode($item->steps_completed, true);
        if ($steps !== null && is_array($steps)) {

            //exclude photos and calendar
            $filteredSteps = array_filter($steps, function ($step, $key) {
                return !in_array($key, ['photos', 'calendar', 'document']);
            }, ARRAY_FILTER_USE_BOTH);

            // Find incomplete steps
            $incompleteSteps = array_keys(array_filter($filteredSteps, function ($step) {
                return !$step;
            }));

            if (empty($incompleteSteps)) {
                $product_status = Item::where('id', $request->pid)->update(['status' => $request->status,]);

                if ($product_status) {

                    if ($request->status == 1) {
                        $template_id = 39;
                    } else {
                        $template_id = 40;
                    }

                    $item = Item::with('userid')->find($request->pid);
                    $user = $item->userid;

                    // Extract the required user details
                    $valuesArray = $user->only(['first_name', 'last_name', 'email']);
                    $valuesArray['title'] = $item->title;
                    $valuesArray['phone'] = $user->phone_country . '' . $user->phone;
                    $this->sendAllNotifications($valuesArray, $user->id, $template_id);

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
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'The following mandatory steps are not completed: ' . implode(', ', $incompleteSteps) . '. Please update them.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Please update every steps to change status.'
            ]);
        }
    }

    public function updateFeatured(Request $request)
    {
        if (Gate::denies('vehicle_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }
        $product_featured = Item::where('id', $request->pid)->update(['is_featured' => $request->featured,]);
        if ($product_featured) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.featured_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }
    }

    public function updateVerified(Request $request)
    {
        if (Gate::denies('vehicle_edit')) {
            return response()->json([
                'message' => "You don't have permission to perform this action."
            ]);
        }

        $product_verified = Item::where('id', $request->pid)->update(['is_verified' => $request->isverified,]);
        if ($product_verified) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.verified_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }
    }

    // In your controller
    public function getIncompleteSteps(Request $request)
    {
        $item = Item::find($request->pid);

        if (!$item) {
            return response()->json([
                'status' => 404,
                'message' => 'Item not found.'
            ]);
        }

        $steps = json_decode($item->steps_completed, true);


        if ($steps !== null && is_array($steps)) {
            // Find incomplete steps
            $incompleteSteps = array_keys(array_filter($steps, function ($step) {
                return !$step;
            }));

            if (!empty($incompleteSteps)) {
                return response()->json([
                    'status' => 200,
                    'incomplete_steps' => $incompleteSteps
                ]);
            } else {
                return response()->json([
                    'status' => 204,
                    'incomplete_steps' => []
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid steps data.'
            ]);
        }
    }
}
