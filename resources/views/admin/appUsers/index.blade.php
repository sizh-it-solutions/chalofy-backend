@extends('layouts.admin')
@php $i = 0;
$j = 0; @endphp
@section('content')
<div class="content">
    @can('app_user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ $userType === 'vendor' 
           ? route('admin.app-vendors.create') 
           : route('admin.app-users.create') }}">
                {{ trans('global.add') }}
                {{ $userType === 'vendor' ? trans('global.vendor') : trans('global.appUser_title_singular') }}
            </a>
        </div>
    </div>
    @endcan
    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET" accept-charset="UTF-8"
                id="appusersFilterForm">

                <div class="col-md-12 d-none">
                    <input class="form-control" type="hidden" id="startDate" name="from" value="">
                    <input class="form-control" type="hidden" id="endDate" name="to" value="">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>{{ trans('global.date_range') }}</label>
                            <div class="input-group col-xs-12">
                                <input autocomplete="off" type="text" class="form-control" id="daterange-btn">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>{{ trans('global.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">All</option>
                                <option value="1" {{ request()->input('status') == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ request()->input('status') == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label> {{ $userType === 'vendor' ? trans('global.vendor') : trans('global.customer')
                                }}</label>
                            <select class="form-control select2"
                                data-type="{{ $userType === 'vendor' ? 'vendor' :'user' }}" name="customer"
                                id="customer">
                                <option value="">{{ $searchfield }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-4 mt-5 mt-4">
                            <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('global.filter')
                                }}</button>
                            <button type="button" id="resetBtn" class="btn btn-primary btn-flat ">{{
                                trans('global.reset') }}</button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
    <div style="margin-bottom: 6px;" class="row">
        <div class="col-lg-12">
            <a class="btn {{ 
        ($userType === 'vendor' && request()->routeIs('admin.app-vendors.index') 
        || $userType !== 'vendor' && request()->routeIs('admin.app-users.index') && is_null(request()->query('status')) && !request()->has('host_status')) 
        ? 'btn-primary' : 'btn-inactive' 
    }}" href="{{ $userType === 'vendor' 
           ? route('admin.app-vendors.index') 
           : route('admin.app-users.index') }}">

                {{ trans('global.all') }}
                <span class="badge badge-pill badge-primary">{{ $statusCounts['live'] > 0 ? $statusCounts['live'] : 0
                    }}</span>
            </a>
            @if($userType === 'user')
            <a class="btn {{ request()->query('status') === '1' && !request()->has('host_status') ? 'btn-primary' : 'btn-inactive' }}"
                href="{{ route('admin.app-users.index', array_merge(request()->except('host_status'), ['status' => 1])) }}">
                Active
                <span class="badge badge-pill badge-primary">{{ $statusCounts['active'] > 0 ? $statusCounts['active'] :
                    0 }}</span>
            </a>
            <a class="btn {{ request()->query('status') === '0' && !request()->has('host_status') ? 'btn-primary' : 'btn-inactive' }}"
                href="{{ route('admin.app-users.index', array_merge(request()->except('host_status'), ['status' => 0])) }}">
                Inactive
                <span class="badge badge-pill badge-primary">{{ $statusCounts['inactive'] > 0 ?
                    $statusCounts['inactive'] : 0 }}</span>
            </a>
            @endif

            @if($userType === 'vendor')
            <a class="btn {{ request()->query('host_status') === '1' ? 'btn-primary' : 'btn-inactive' }}"
                href="{{ route('admin.app-vendors.index', array_merge(request()->except('status'), ['host_status' => 1])) }}">
                Verified
                <span class="badge badge-pill badge-primary">{{ $statusCounts['verified'] > 0 ?
                    $statusCounts['verified'] : 0 }}</span>
            </a>
            <a class="btn {{ request()->query('host_status') === '2' ? 'btn-primary' : 'btn-inactive' }}"
                href="{{ route('admin.app-vendors.index', array_merge(request()->except('status'), ['host_status' => 2])) }}">
                Requested
                <span class="badge badge-pill badge-primary">{{ $statusCounts['requested'] > 0 ?
                    $statusCounts['requested'] : 0 }}</span>
            </a>
            @endif
        </div>
    </div>
    <div id="loader" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            @if($userType === 'vendor')
            {{ trans('global.vendor') }}
            @else
            {{ trans('global.appUser_title') }}
            @endif {{ trans('global.list') }}
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-AppUser">
                    <thead>
                        <tr>
                            <th></th>

                            <th>
                                {{ trans('global.id') }}
                            </th>
                            <th>
                                {{ trans('global.first_name') }}
                            </th>
                            @if($userType === 'vendor')
                            <th>
                                {{ trans('global.vehicles') }}
                            </th>
                            @endif
                            <th>
                                {{ trans('global.email_verify') }}
                            </th>
                            <th>
                                {{ trans('global.phone_verify') }}
                            </th>

                            <th>
                                {{ trans('global.status') }}
                            </th>
                            @if($userType === 'vendor')
                            <th>
                                {{ trans('global.vendor_status') }}
                            </th>
                            @endif
                            <th>
                                {{ trans('global.date') }}
                            </th>
                            <th>&nbsp;

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appUsers as $key => $appUser)
                        <tr data-entry-id="{{$appUser->id}}">
                            <td></td>
                            @php
                            $routeName = ($userType == 'user') ? 'admin.customer.profile' : 'admin.vendor.profile';
                            @endphp
                            <td>
                                <a target="_blank" class="btn btn-xs btn-primary"
                                    href="{{ route($routeName, $appUser->id) }}">#{{
                                    $appUser->id ?? '' }}</a>
                            </td>
                            <td>
                                <div class="row" style="margin: 0;">

                                    <div class="col-xs-2" style="padding-right: 5px;">
                                        @if($appUser->profile_image)
                                        <a href="{{ $appUser->profile_image->getUrl() }}" target="_blank"
                                            style="display: inline-block">
                                            <img src="{{ $appUser->profile_image->getUrl('thumb') }}">
                                        </a>
                                        @else
                                        <img src="{{ asset('images/icon/userdefault.jpg') }}" alt="Default Image"
                                            style="display: inline-block;">
                                        @endif
                                    </div>
                                    <div class="col-xs-10" style="padding-left:30px;">
                                        <a target="_blank" class="btn btn-xs"
                                            href="{{route($routeName, $appUser->id) }}">
                                            <strong> {{ $appUser->first_name ?? '' }} {{ $appUser->last_name ?? ''
                                                }}</strong>
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            @can('app_user_contact_access')
                                            {{ $appUser->email }}
                                            @else
                                            {{ maskEmail($appUser->email) }}
                                            @endcan
                                            <br>
                                            {{ $appUser->phone_country ?? '' }}
                                            @can('app_user_contact_access')

                                            {{ $appUser->phone ?? '' }}
                                            @else
                                            {{ $appUser->phone ? substr($appUser->phone, 0, -6) . str_repeat('*', 6) :
                                            '' }}
                                            @endcan

                                        </small>
                                    </div>
                                </div>



                            </td>
                            @if($userType === 'vendor')
                            <td>
                                {{ $appUser->items ? $appUser->items->count() : 0 }}
                            </td>
                            @endif
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="{{$appUser->id}}" class="check email_verify" type="checkbox"
                                        data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" {{
                                        $appUser->email_verify ?
                                    'checked' : '' }}>
                                    <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>

                                </div>
                            </td>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="{{$appUser->id}}" class="check phone_verify" type="checkbox"
                                        data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" {{ $appUser->phone_verify ?
                                    'checked' : '' }}>
                                    <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                </div>
                            </td>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="{{$appUser->id}}" class="check statusdata" type="checkbox"
                                        data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" {{ $appUser->status ?
                                    'checked' : '' }}>
                                    <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                </div>

                            </td>
                            
                            @if($userType === 'vendor')
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    @if (
                                    $appUser->metadata->contains(function ($meta) {
                                    return $meta->meta_key === 'host_form_data';
                                    })
                                    )
                                    <a target="_blank" class="btn btn-xs btn-primary"
                                    href="{{ route('admin.vendor.account', $appUser->id) }}">  <i class="fa fa-file view-details" data-id="{{ $appUser->id }}"
                                        style="cursor: pointer;" title="View Details"></i></a>
                                    @endif
                                    @if($appUser->host_status == 2)

                                    <span class="requested-label">Requested</span>

                                    <input data-id="{{$appUser->id}}" class="check hoststatusdata" type="checkbox"
                                        data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive">
                                    @else
                                    <input data-id="{{$appUser->id}}" class="check hoststatusdata" type="checkbox"
                                        data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" {{
                                        $appUser->host_status ? 'checked' : '' }}>
                                    @endif
                                    <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                </div>
                            </td>
                            @endif

                            <td>{{ $appUser->created_at ? $appUser->created_at->format('F j, Y g:i A') : '' }}</td>
                            <td>
                                @can('app_user_show')
                                <a class="btn btn-xs btn-primary" target="_blank"
                                    href="{{ route($routeName, $appUser->id) }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                @endcan

                                @can('app_user_edit')
                                <a class="btn btn-xs btn-info" target="_blank"
                                    href="{{ route($routeName, $appUser->id) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                @endcan
                                @can('app_user_delete')
                                <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                    data-id="{{ $appUser->id }}">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                @endcan
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination justify-content-end">
                        @if ($appUsers->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $appUsers->previousPageUrl() }}" tabindex="-1">{{
                                trans('global.previous') }}</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">{{ trans('global.previous') }}</span>
                        </li>
                        @endif
                        @for ($i = 1; $i <= $appUsers->lastPage(); $i++)
                            <li class="page-item {{ $i == $appUsers->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $appUsers->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            @if ($appUsers->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $appUsers->nextPageUrl() }}">{{ trans('global.next')
                                    }}</a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">{{ trans('global.next') }}</span>
                            </li>
                            @endif
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Host Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="modal-table">
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>

    $(document).ready(function () {

        attachDeleteButtons('app-users', {
            title: '{{ trans('global.are_you_sure') }}',
            text: '{{ trans('global.delete_confirmation') }}',
            confirmButtonText: '{{ trans('global.yes_delete_it') }}',
            cancelButtonText: '{{ trans('global.cancel') }}',
        });

        let deleteRoute = "{{ route('admin.app-users.deleteAll') }}";

        attachBulkDeleteButton({
            datatableSelector: '.datatable-AppUser:not(.ajaxTable)',
            deleteRoute: deleteRoute,
            buttonText: '{{ trans('global.delete_all') }}',
            buttonClass: 'btn-danger',
            swalOptions: {
                title: '{{ trans('global.are_you_sure') }}',
                text: '{{ trans('global.delete_confirmation') }}',
                confirmButtonText: '{{ trans('global.yes_delete') }}',
                cancelButtonText: '{{ trans('global.cancel') }}',
                noSelectionTitle: '{{ trans('global.no_entries_selected') }}',
                okButtonText: 'OK'
            }
        });

        let dataType = $('#customer').attr('data-type');
        attachAjaxSelect(
            '#customer',
            '{{ route("admin.searchcustomer") }}',
            item => ({ id: item.id, text: item.name }),
            @json(isset($searchfieldId) ? ['id' => $searchfieldId, 'text' => $searchfield] : null), {
            data_type: dataType
        }
        );
    });


    handleToggleUpdate(
        '.statusdata',
        '/admin/update-appuser-status',
        'status',
        {
            title: '{{ trans("global.are_you_sure") }}',
            text: '{{ trans("global.change_status_confirmation") }}',
            confirmButtonText: '{{ trans("global.yes_continue") }}',
            cancelButtonText: '{{ trans("global.cancel") }}'
        }
    );

    handleToggleUpdate(
        '.identify',
        '/admin/update-appuser-identify',
        'verified',
        {
            title: '{{ trans("global.are_you_sure") }}',
            text: '{{ trans("global.change_status_confirmation") }}',
            confirmButtonText: '{{ trans("global.yes_continue") }}',
            cancelButtonText: '{{ trans("global.cancel") }}'
        }
    );

    handleToggleUpdate(
        '.phone_verify',
        '/admin/update-appuser-phoneverify',
        'phone_verify',
        {
            title: '{{ trans("global.are_you_sure") }}',
            text: '{{ trans("global.change_status_confirmation") }}',
            confirmButtonText: '{{ trans("global.yes_continue") }}',
            cancelButtonText: '{{ trans("global.cancel") }}'
        }
    );

    handleToggleUpdate(
        '.email_verify',
        '/admin/update-appuser-emailverify',
        'email_verify',
        {
            title: '{{ trans("global.are_you_sure") }}',
            text: '{{ trans("global.change_status_confirmation") }}',
            confirmButtonText: '{{ trans("global.yes_continue") }}',
            cancelButtonText: '{{ trans("global.cancel") }}'
        }
    );

    handleToggleUpdate(
        '.hoststatusdata',
        '/admin/update-appuser-host-status',
        'status',
        {
            title: '{{ trans("global.are_you_sure") }}',
            text: '{{ trans("global.change_status_confirmation") }}',
            confirmButtonText: '{{ trans("global.yes_continue") }}',
            cancelButtonText: '{{ trans("global.cancel") }}'
        }
    );


    attachFilterResetButton('#appusersFilterForm', ['#status',
        '#daterange-btn'
    ]);




</script>
@endsection