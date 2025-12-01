<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{MediaUploadingTrait, NotificationTrait, VendorWalletTrait};
use App\Http\Requests\StoreAppUserRequest;
use App\Http\Requests\UpdateAppUserRequest;
use App\Models\AllPackage;
use App\Models\{GeneralSetting, Payout};
use App\Models\AppUser;
use App\Models\AppUserMeta;
use App\Models\VendorWallet;
use App\Models\Modern\ItemType;
use Gate;
use \Hash;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AppUsersController extends Controller
{
    use MediaUploadingTrait, NotificationTrait, VendorWalletTrait;





    public function index()
    {
        abort_if(Gate::denies('app_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $routeName = request()->route()->getName();
        $userType = str_contains($routeName, 'app-vendors') ? 'vendor' : 'user';

        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');
        $customer = request()->input('customer');
        $hostStatus = request()->input('host_status');

        $baseQuery = AppUser::with(['media', 'metadata', 'items'])
            ->where('user_type', $userType);

        if ($from && $to) {
            $baseQuery->whereBetween('created_at', [
                date("Y-m-d", strtotime($from)) . ' 00:00:00',
                date("Y-m-d", strtotime($to)) . ' 23:59:59'
            ]);
        } elseif ($from) {
            $baseQuery->where('created_at', '>=', date("Y-m-d", strtotime($from)) . ' 00:00:00');
        } elseif ($to) {
            $baseQuery->where('created_at', '<=', date("Y-m-d", strtotime($to)) . ' 23:59:59');
        }




        if ($customer) {
            $baseQuery->where('id', $customer);
        }

        // Clone for counts without affecting the original query
        $countQuery = (clone $baseQuery);

        if ($status !== null) {
            $baseQuery->where('status', $status);
        }

        if ($hostStatus !== null) {
            $baseQuery->where('host_status', $hostStatus);
        }
        // Paginate the main query
        $appUsers = $baseQuery->orderBy('id', 'desc')->paginate(50);
        $appUsers->appends(request()->only(['from', 'to', 'status', 'customer', 'host_status']));

        // For search field display
        $selectedUser = $customer ? AppUser::find($customer) : null;
        $searchfield = $selectedUser ? "{$selectedUser->first_name} {$selectedUser->last_name} ({$selectedUser->phone})" : 'All';
        $searchfieldId = $selectedUser->id ?? '';

        // Count with applied filters
        $statusCountsRaw = $countQuery->selectRaw('
        COUNT(*) as live,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active,
        SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive,
        SUM(CASE WHEN host_status = "1" THEN 1 ELSE 0 END) as verified,
        SUM(CASE WHEN host_status = "2" THEN 1 ELSE 0 END) as requested
    ')->first();

        $statusCounts = [
            'live' => $statusCountsRaw->live ?? 0,
            'active' => $statusCountsRaw->active ?? 0,
            'inactive' => $statusCountsRaw->inactive ?? 0,
            'verified' => $statusCountsRaw->verified ?? 0,
            'requested' => $statusCountsRaw->requested ?? 0,
        ];

        return view('admin.appUsers.index', compact(
            'appUsers',
            'statusCounts',
            'searchfield',
            'searchfieldId',
            'userType'
        ));
    }



    public function create()
    {
        abort_if(Gate::denies('app_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $routeName = request()->route()->getName();
        $userType = str_contains($routeName, 'app-vendors') ? 'vendor' : 'user';
        $packages = AllPackage::pluck('package_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $api_google_map_key = GeneralSetting::where('meta_key', 'api_google_map_key')->first();
        return view('admin.appUsers.create', compact('packages', 'api_google_map_key', 'userType'));
    }

    public function store(StoreAppUserRequest $request)
    {
        $userEmail = AppUser::where('email', $request->email)->first();
        $userType = $request->input('user_type');
        $redirectUrl = "admin/app-users/create?user_type={$userType}";

        if ($userEmail) {
            return redirect()->to($redirectUrl)->withErrors(['email' => 'Email already exists.']);
        }
        $userPhone = AppUser::where('phone', $request->phone)->first();
        if ($userPhone) {
            return redirect()->to($redirectUrl)->withErrors(['phone' => 'Phone number already exists.']);
        }


        // $appUser = AppUser::create($request->all());
        $data = $request->all();
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $appUser = AppUser::create($data);

        if ($request->input('profile_image', false)) {
            $appUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $appUser->id]);
        }

        if ($request->input('user_type') === 'vendor') {
            $appUser->update([
                'host_status' => $request->input('host_status'),
                'user_type' => 'vendor',
            ]);

            $hostFormData = $request->only([
                'host_status',
                'first_name',
                'last_name',
                'company_name',
                'phone',
                'residency_type',
                'full_address',
                'identity_type'
            ]);

            // Save identity image
            if (!empty($request->input('identity_image'))) {
                $identityImagePath = storage_path('tmp/uploads/' . basename($request->input('identity_image')));
                $appUser->addMedia($identityImagePath)->toMediaCollection('identity_image');
            }

            AppUserMeta::updateOrCreate(
                ['user_id' => $appUser->id, 'meta_key' => 'host_form_data'],
                ['meta_value' => json_encode($hostFormData)]
            );
        }



        $userType = $request->input('user_type');

        return redirect()->to(route('admin.app-users.index', ['user_type' => $userType]));
    }

    public function edit(AppUser $appUser)
    {
        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = AllPackage::pluck('package_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $appUser->load('package');

        return view('admin.appUsers.edit', compact('appUser', 'packages'));
    }

    public function update(UpdateAppUserRequest $request, AppUser $appUser)
    {
        if ($request->has('email') && $request->email !== $appUser->email) {
            $userEmail = AppUser::where('email', $request->email)->first();

            if ($userEmail && $userEmail->id !== $appUser->id) {
                return redirect()->to("admin/app-users/{$appUser->id}/edit?user_type=" . request()->input('user_type'))
                    ->withErrors(['email' => 'Email already exists.']);
            }
        }

        $userPhone = AppUser::where('phone', $request->phone)->first();
        if ($userPhone && $userPhone->id !== $appUser->id) {
            return redirect()->to("admin/app-users/{$appUser->id}/edit?user_type=" . request()->input('user_type'))
                ->withErrors(['phone' => 'Phone number already exists.']);
        }

        $data = $request->except(['password', 'user_type']);

        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $appUser->update($data);

        // Handle profile image
        if ($request->input('profile_image', false)) {
            if (!$appUser->profile_image || $request->input('profile_image') !== $appUser->profile_image->file_name) {
                if ($appUser->profile_image) {
                    $appUser->profile_image->delete();
                }
                $appUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))
                    ->toMediaCollection('profile_image');
            }
        } elseif ($appUser->profile_image) {
            $appUser->profile_image->delete();
        }

        // Handle vendor metadata fields
        if ($request->input('user_type') === 'vendor') {
            // Update host status and user type
            $appUser->update([
                'host_status' => $request->input('host_status'),
                'user_type' => 'vendor',
            ]);

            // Prepare host form data
            $hostFormData = $request->only([
                'host_status',
                'first_name',
                'last_name',
                'company_name',
                'phone',
                'residency_type',
                'full_address',
                'identity_type'
            ]);

            // Save identity image if provided
            if (!empty($request->input('identity_image'))) {
                if (!$appUser->identity_image || $request->input('identity_image') !== $appUser->identity_image->file_name) {
                    if ($appUser->identity_image) {
                        $appUser->identity_image->delete();
                    }
                    $identityImagePath = storage_path('tmp/uploads/' . basename($request->input('identity_image')));
                    $appUser->addMedia($identityImagePath)->toMediaCollection('identity_image');
                }
            } elseif ($appUser->identity_image) {
                $appUser->identity_image->delete();
            }
            // Save the host form data in metadata
            AppUserMeta::updateOrCreate(
                ['user_id' => $appUser->id, 'meta_key' => 'host_form_data'],
                ['meta_value' => json_encode($hostFormData)]
            );
        }

        // Redirect to the appropriate page
        $redirectUrl = 'admin.app-users.index';
        if ($request->has('from_overviewprofile') && $request->input('from_overviewprofile') == 'true') {
            if ($request->input('user_type') === 'vendor') {
                $redirectUrl = route('admin.vendor.account', ['id' => $appUser->id]);
            } else {
                $redirectUrl = route('admin.customer.account', ['id' => $appUser->id]);

            }


        }

        $userType = request()->input('user_type', 'user');

        if ($redirectUrl === 'admin.app-users.index') {
            return redirect()->route(
                $redirectUrl
            );
        }

        return redirect()->to($redirectUrl);
    }

    public function show(AppUser $appUser)
    {
        abort_if(Gate::denies('app_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appUser->load('package');

        return view('admin.appUsers.show', compact('appUser'));
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('app_user_create') && Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new AppUser();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    //

    public function customerSearch(Request $request)
    {
        $searchTerm = $request->input('q');
        $userType = strtolower($request->input('data_type'));
        $page = $request->input('page', 1);
        $perPage = 20;

        $query = AppUser::query();

        if ($userType === 'vendor') {
            $query->where('user_type', 'vendor');
        } elseif ($userType === 'customer') {
            $query->where('user_type', 'user');
        } elseif ($userType === 'user') {
            $query->where('user_type', 'user');
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%');
            });
        }
        $customers = $query
            ->select('id', 'first_name', 'last_name', 'phone')
            ->orderBy('first_name')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $data = [];
        foreach ($customers as $customer) {
            $name = $customer->first_name . ' ' . $customer->last_name . ' (' . $customer->phone . ')';
            $data[] = [
                'id' => $customer->id,
                'text' => $name,
            ];
        }

        return response()->json([
            'results' => $data,
            'pagination' => ['more' => $customers->count() === $perPage]
        ]);
    }


    public function hostSearch(Request $request)
    {

        $searchTerm = $request->input('q');

        $customers = AppUser::where('host_status', '1')
            ->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        $data = [];
        foreach ($customers as $customer) {

            $name = $customer->first_name . ' ' . $customer->last_name . '(' . $customer->phone . ')';
            $data[] = [
                'id' => $customer->id,
                'name' => $customer->first_name,
                'first_name' => $name,
            ];
        }
        return response()->json($data);
    }
    public function userSearch(Request $request)
    {
        // Get the search term entered by the user
        $searchTerm = $request->input('q');

        $customers = AppUser::where('host_status', '0') // Only include customers with host_status = 1
            ->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        $data = [];
        foreach ($customers as $customer) {

            $name = $customer->first_name . ' ' . $customer->last_name . '(' . $customer->phone . ')';
            $data[] = [
                'id' => $customer->id,
                'name' => $customer->first_name,
                'first_name' => $name,
            ];
        }
        return response()->json($data);
    }
    public function updateStatus(Request $request)
    {
        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Gate::denies('app_user_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }
        $statusData = AppUser::where('id', $request->pid)->update(['status' => $request->status,]);
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
    public function updateHostStatus(Request $request)
    {

        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Gate::denies('app_user_edit')) {
            return response()->json([
                'status' => 403,
                'message' => "You don't have permission to perform this action."
            ], 403);
        }


        $hostFormData = AppUserMeta::where('user_id', $request->pid)
            ->where('meta_key', 'host_form_data')
            ->pluck('meta_value')
            ->first();

        if (!$hostFormData) {
            return response()->json([
                'status' => 403,
                'message' => "This user has not submitted host request."
            ], 403);
        }

        $statusData = AppUser::where('id', $request->pid)->update(['host_status' => $request->status,]);



        if ($statusData) {


            $user = AppUser::where('id', $request->pid)->first();

            if ($user->host_status) {
                $template_id = 35;
                $valuesArray = $user->toArray();
                $valuesArray = $user->only(['first_name', 'last_name', 'email']);
                $settings = GeneralSetting::whereIn('meta_key', ['general_email'])->get()->keyBy('meta_key');

                $general_email = $settings['general_email']->meta_value ?? null;

                $valuesArray['support_email'] = $general_email;
                $valuesArray['phone'] = $user->phone_country . $user->phone;
                $this->sendAllNotifications($valuesArray, $request->pid, $template_id);
            }

            // setting the status field in rental_table
            $user->items()->update(['status' => $request->status]);

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
    public function updateIdentify(Request $request)
    {
        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $verified = AppUser::where('id', $request->pid)->update(['verified' => $request->verified,]);
        if ($verified) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.identify_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }
    }
    public function updatePhoneverify(Request $request)
    {
        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $phoneVerify = AppUser::where('id', $request->pid)->update(['phone_verify' => $request->phone_verify,]);
        if ($phoneVerify) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.phone_verify_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }
    }
    public function updateEmailverify(Request $request)
    {

        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $emailVerify = AppUser::where('id', $request->pid)->update(['email_verify' => $request->email_verify,]);
        if ($emailVerify) {
            return response()->json([
                'status' => 200,
                'message' => trans('global.email_verify_updated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'something went wrong. Please try again.'
            ]);
        }
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('app_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appUser = AppUser::findOrFail($id);

        if ($appUser) {
            $appUser->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'appUser deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: appUser cannot be deleted from this module'
            ], Response::HTTP_FORBIDDEN);
        }
    }

    // App Users data Trash

    public function appUserTrashed()
    {
        abort_if(Gate::denies('app_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');
        $customer = request()->input('customer');

        $query = AppUser::onlyTrashed()->with(['package', 'media'])->orderBy('id', 'desc');

        $isFiltered = ($from || $to || $status || $customer);

        if ($from && $to) {
            $query->whereBetween('created_at', [date("Y-m-d", strtotime($from)) . ' 00:00:00', date("Y-m-d", strtotime($to)) . ' 23:59:59']);
        } elseif ($from) {
            $query->where('created_at', '>=', date("Y-m-d", strtotime($from)) . ' 00:00:00');
        } elseif ($to) {
            $query->where('created_at', '<=', date("Y-m-d", strtotime($to)) . ' 23:59:59');
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($customer) {
            $query->where('id', $customer);
        }

        $appUsers = $isFiltered ? $query->paginate(50) : $query->paginate(50);

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
        if ($customer != null) {
            $queryParameters['customer'] = $customer;
        }
        if ($customer != null && $status != '' && $from != '' && $to != '') {
            $queryParameters['customer'] = $customer;
            $queryParameters['status'] = $status;
            $queryParameters['to'] = $to;
            $queryParameters['from'] = $from;
        }
        $appUsers->appends($queryParameters);

        $fielddata = request()->input('customer');
        $fieldname = AppUser::find($fielddata);

        if ($fieldname) {

            $searchfield = $fieldname->first_name . ' ' . $fieldname->last_name . '(' . $fieldname->phone . ')';
        } else {

            $searchfield = 'All';
        }

        $statusCounts = [
            'live' => AppUser::count(),
            'active' => AppUser::where('status', 1)->count(),
            'inactive' => AppUser::where('status', 0)->count(),
            'mail' => AppUser::whereNotNull('email')->count(),
            'trash' => AppUser::onlyTrashed('trash')->count(),
        ];

        return view('admin.appUsers.trash', compact('appUsers', 'statusCounts', 'searchfield'));
    }

    public function restoreTrash($id)
    {
        $item = AppUser::onlyTrashed()->findOrFail($id);
        $item->restore();

        return;
    }


    public function permanentDelete($id)
    {
        $appUser = AppUser::onlyTrashed()->findOrFail($id);
        if ($appUser->profile_image) {
            $appUser->profile_image->delete();
            $appUser->clearMediaCollection('profile_image');
        }
        $appUser->forceDelete();

        return response()->json(['message' => 'User permanently deleted successfully.']);
    }



    public function permanentDeleteAll(Request $request)
    {

        $trashedUsers = AppUser::onlyTrashed()->limit(5)->get();

        if ($trashedUsers->isEmpty()) {
            return response()->json(['message' => trans('global.no_items_to_delete')], 404);
        }

        foreach ($trashedUsers as $user) {

            if ($user->profile_image) {
                $user->profile_image->delete();
                $user->clearMediaCollection('profile_image');
            }



            $user->forceDelete();
        }

        return response()->json(['message' => trans('global.all_permanently_deleted_success')]);
    }



    public function deleteAll(Request $request)
    {
        abort_if(Gate::denies('app_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->input('ids');
        if (!empty($ids)) {
            try {

                AppUser::whereIn('id', $ids)->forceDelete();
                return response()->json(['message' => 'Items deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['message' => 'No entries selected'], 400);
    }

    public function deleteTrashAll(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            try {

                $trashedUsers = AppUser::onlyTrashed()->whereIn('id', $ids)->get();

                foreach ($trashedUsers as $user) {

                    if ($user->profile_image) {
                        $user->profile_image->delete();
                    }


                    $user->clearMediaCollection('profile_image');


                    $user->forceDelete();
                }

                return response()->json(['message' => 'Items deleted from trash successfully'], Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return response()->json(['message' => 'No entries selected'], Response::HTTP_BAD_REQUEST);
    }


    public function getHostStatusDetailbkp(Request $request)
    {


        $userId = $request->input('user_id');

        $hostFormData = AppUserMeta::where('user_id', $userId)
            ->where('meta_key', 'host_form_data')
            ->pluck('meta_value')
            ->first();


        $hostFormData = json_decode($hostFormData, true);

        $appUser = AppUser::find($userId);

        $image = $appUser && $appUser->identity_image ? $appUser->identity_image->getUrl() : null;


        // Add the image URL to the response data
        $hostFormData['image'] = $image;

        if (isset($hostFormData['host_status'])) {
            unset($hostFormData['host_status']);
        }

        return response()->json(['data' => $hostFormData]);
    }
    public function getHostStatusDetail(Request $request)
    {


        $userId = $request->input('user_id');

        $hostFormData = AppUserMeta::where('user_id', $userId)
            ->where('meta_key', 'host_form_data')
            ->pluck('meta_value')
            ->first();


        $hostFormData = json_decode($hostFormData, true);

        $appUser = AppUser::find($userId);

        $image = $appUser && $appUser->identity_image ? $appUser->identity_image->getUrl() : null;


        // Add the image URL to the response data
        $hostFormData['image'] = $image;

        if (isset($hostFormData['host_status'])) {
            unset($hostFormData['host_status']);
        }

        if (Gate::denies('app_user_contact_access')) {

            if (isset($hostFormData['phone'])) {
                $hostFormData['phone'] = $this->maskPhoneNumber($hostFormData['phone']);
            }

            if (isset($hostFormData['email'])) {
                $hostFormData['email'] = $this->maskEmail($hostFormData['email']);
            }
        }
        return response()->json(['data' => $hostFormData]);
    }

    private function maskPhoneNumber($phone)
    {
        return substr($phone, 0, -4) . str_repeat('*', 4);
    }


    private function maskEmail($email)
    {
        [$user, $domain] = explode('@', $email);
        $maskedUser = substr($user, 0, 1) . str_repeat('*', max(strlen($user) - 2, 0)) . substr($user, -1);

        return $maskedUser . '@' . $domain;
    }

    public function editVendorAccount(Request $request, $booking)
    {


        $appUser = AppUser::with(['package', 'metadata'])->findOrFail($booking);
        $user = $appUser;

        $packages = AllPackage::pluck('package_name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');
        $userType = $appUser->user_type === 'vendor' ? 'vendor' : 'user';
        $hostFormDataMeta = $appUser->metadata->firstWhere('meta_key', 'host_form_data');
        $hostFormData = $hostFormDataMeta ? json_decode($hostFormDataMeta->meta_value, true) : null;

        $api_google_map_key = GeneralSetting::where('meta_key', 'api_google_map_key')->value('meta_value');

        return view('admin.appUsers.vendor.account', compact(
            'booking',
            'user',
            'appUser',
            'packages',
            'hostFormData',
            'api_google_map_key',
            'userType'
        ));
    }

    public function editCustomerAccount(Request $request, $booking)
    {
        echo "hell0";
        abort_if(Gate::denies('app_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $appUser = AppUser::with(['package', 'metadata'])->findOrFail($booking);
        $user = $appUser;

        $packages = AllPackage::pluck('package_name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');
        $userType = $appUser->user_type === 'vendor' ? 'vendor' : 'user';
        $hostFormDataMeta = $appUser->metadata->firstWhere('meta_key', 'host_form_data');
        $hostFormData = $hostFormDataMeta ? json_decode($hostFormDataMeta->meta_value, true) : null;

        $api_google_map_key = GeneralSetting::where('meta_key', 'api_google_map_key')->value('meta_value');

        return view('admin.appUsers.user.account', compact(
            'booking',
            'user',
            'appUser',
            'packages',
            'hostFormData',
            'api_google_map_key',
            'userType'
        ));
    }


    public function viewVendorProfile(Request $request, $userId)
    {
        if (!is_numeric($userId)) {
            abort(404, 'Invalid user ID');
        }

        $appUser = AppUser::with(['hostBookings', 'items'])->findOrFail($userId);

        $today = now()->startOfDay();
        $aggregates = $appUser->hostBookings()
            ->leftJoin('booking_finance', 'bookings.id', '=', 'booking_finance.booking_id')
            ->selectRaw("
        COUNT(bookings.id) as total_bookings,
        SUM(bookings.status = 'pending') as pending_bookings,
        SUM(bookings.status = 'confirmed') as confirmed_bookings,
        SUM(bookings.status = 'cancelled') as cancelled_bookings,
        SUM(bookings.status = 'declined') as declined_bookings,
        SUM(bookings.status = 'completed') as completed_bookings,
        SUM(CASE WHEN bookings.status = 'completed' AND bookings.created_at >= ? THEN total ELSE 0 END) as today_earnings,
        SUM(CASE WHEN bookings.status = 'completed' AND bookings.created_at >= ? THEN booking_finance.admin_commission ELSE 0 END) as admin_commission,
        SUM(CASE WHEN bookings.status = 'completed' AND bookings.created_at >= ? THEN booking_finance.vendor_commission ELSE 0 END) as driver_earnings,
        SUM(CASE WHEN bookings.status = 'completed' AND bookings.payment_method = 'offline' AND bookings.created_at >= ? THEN booking_finance.vendor_commission ELSE 0 END) as cash_earnings,
        SUM(CASE WHEN bookings.status = 'completed' AND bookings.payment_method != 'offline' AND bookings.created_at >= ? THEN booking_finance.vendor_commission ELSE 0 END) as online_earnings
    ", [$today, $today, $today, $today, $today])
            ->first();


        $vehicle = $appUser->items->first();
        $general_default_currency = cache()->remember('general_default_currency', now()->addHours(24), fn() => View::shared('general_default_currency'));

        $data = [
            'pending_bookings' => (int) ($aggregates->pending_bookings ?? 0),
            'confirmed_bookings' => (int) ($aggregates->confirmed_bookings ?? 0),
            'cancelled_bookings' => (int) ($aggregates->cancelled_bookings ?? 0),
            'declined_bookings' => (int) ($aggregates->declined_bookings ?? 0),
            'completed_bookings' => (int) ($aggregates->completed_bookings ?? 0),
            'total_bookings' => (int) ($aggregates->total_bookings ?? 0),
            'today_earnings' => number_format($aggregates->today_earnings ?? 0, 2, '.', ''),
            'admin_commission' => number_format($aggregates->admin_commission ?? 0, 2, '.', ''),
            'driver_earnings' => number_format($aggregates->driver_earnings ?? 0, 2, '.', ''),
            'cash_earnings' => number_format($aggregates->cash_earnings ?? 0, 2, '.', ''),
            'online_earnings' => number_format($aggregates->online_earnings ?? 0, 2, '.', '')
        ];

        return view('admin.appUsers.vendor.profile', compact('appUser', 'data', 'userId', 'general_default_currency'));

    }


    public function viewCustomerProfile(Request $request, $userId)
    {
        $appUser = AppUser::findOrFail($userId);
        $userId = $appUser->id;
        if (!is_numeric($userId)) {
            abort(404, 'Invalid user ID');
        }

        $statusCounts = $appUser->bookings()
            ->selectRaw("
        COUNT(*) as total,
        SUM(status = 'pending') as pending,
        SUM(status = 'confirmed') as confirmed,
        SUM(status = 'cancelled') as cancelled,
        SUM(status = 'decline') as declined,
        SUM(status = 'completed') as completed
    ")
            ->first();
        $data = [
            'pending_bookings' => (int) ($statusCounts->pending ?? 0),
            'confirmed_bookings' => (int) ($statusCounts->confirmed ?? 0),
            'cancelled_bookings' => (int) ($statusCounts->cancelled ?? 0),
            'declined_bookings' => (int) ($statusCounts->declined ?? 0),
            'completed_bookings' => (int) ($statusCounts->completed ?? 0),
            'total_bookings' => (int) ($statusCounts->total ?? 0),
        ];
        return view('admin.appUsers.user.profile', compact('appUser', 'data', 'userId'));
    }

    public function vendorFinanceView(Request $request, $userId)
    {
        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');

        $vendor_wallets = VendorWallet::with(['booking:id,token'])
            ->where('vendor_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(50);

        $appUser = AppUser::select('id', 'first_name', 'last_name')->where('id', $userId)->firstOrFail();
        $hostspendmoney = number_format($this->getVendorWalletBalance($userId), 2);
        $hostpendingmoney = number_format($this->getTotalWithdrawlForVendor($userId, 'Pending'), 2);
        $hostrecivemoney = number_format($this->getTotalWithdrawlForVendor($userId, 'Success'), 2);
        $totalmoney = number_format($this->getTotalEarningsForVendor($userId), 2);
        $refunded = number_format($this->getTotalRefundForVendor($userId, ''), 2);

        return view('admin.appUsers.vendor.finance', compact('userId', 'hostspendmoney', 'hostpendingmoney', 'hostrecivemoney', 'totalmoney', 'refunded', 'vendor_wallets', 'appUser'));
    }

    public function vendorPayoutsView(Request $request, $driver_id)
    {

        abort_if(Gate::denies('payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = request()->input('from');
        $to = request()->input('to');
        $status = request()->input('status');
        $appUser = AppUser::where('id', $driver_id)->first();
        $query = Payout::with('vendor')
            ->where('vendorid', $driver_id);
        $isFiltered = ($from || $to || $status);
        if ($from && $to) {
            $query->where(function ($query) use ($from, $to) {
                $query->whereBetween('payouts.created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                    ->orWhereBetween('payouts.updated_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
            });
        } elseif ($from) {
            $query->where(function ($query) use ($from) {
                $query->where('payouts.created_at', '>=', $from . ' 00:00:00')
                    ->orWhere('payouts.updated_at', '>=', $from . ' 00:00:00');
            });
        } elseif ($to) {
            $query->where(function ($query) use ($to) {
                $query->where('payouts.created_at', '<=', $to . ' 23:59:59')
                    ->orWhere('payouts.updated_at', '<=', $to . ' 23:59:59');
            });
        }

        if ($status !== null) {
            $query->where('payout_status', $status);
        }
        $payouts = $isFiltered ? $query->paginate(50) : $query->paginate(50);
        return view('admin.appUsers.vendor.payouts', compact('payouts', 'appUser', 'driver_id'));
    }

}
