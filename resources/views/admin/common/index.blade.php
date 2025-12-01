@extends('layouts.admin')
@section('content')
@php $i = 0;
$j = 0;
if ($title == 'vehicles')
$title = 'vehicle';
else
$title = $title;

@endphp
<div class="content">

    @can($title . '_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.' . $realRoute . '.create') }}">
                {{ trans('global.add') }} {{ $title}}
            </a>
        </div>
    </div>
    @endcan



    <div class="row">

        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-horizontal" id="itemFilterForm" action="" method="GET" accept-charset="UTF-8">

                        <div>
                            <input class="form-control" type="hidden" id="startDate" name="from" value="">
                            <input class="form-control" type="hidden" id="endDate" name="to" value="">
                        </div>


                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <label>Type</label>
                                <select class="form-control select2" name="type" id="type">
                                    <option value=""> {{$typeName}} </option>

                                </select>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>{{ trans('global.date_range') }}</label>
                                <div class="input-group col-xs-12">

                                    <input type="text" class="form-control" id="daterange-btn" autocomplete="off">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label> {{ trans('global.status') }}</label>
                                <select class="form-control select2" name="status" id="status">
                                    <option value="">All</option>
                                    <option value="active" {{ request()->input('status') === 'active' ? 'selected' : ''
                                        }}>Active</option>
                                    <option value="inactive" {{ request()->input('status') === 'inactive' ? 'selected' :
                                        '' }}>Inactive</option>
                                    <option value="verified" {{ request()->input('status') === 'verified' ? 'selected' :
                                        '' }}>Verified</option>
                                    <option value="featured" {{ request()->input('status') === 'featured' ? 'selected' :
                                        '' }}>Featured</option>
                                </select>

                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Progress</label>
                                <select class="form-control select2" id="step_progress_range"
                                    name="step_progress_range">
                                    <option value="">Select a range</option>
                                    <option value="0-25" {{ request()->input('step_progress_range') == '0-25' ?
                                        'selected' : '' }}>0% - 25%</option>
                                    <option value="26-50" {{ request()->input('step_progress_range') == '26-50' ?
                                        'selected' : '' }}>26% - 50%</option>
                                    <option value="51-75" {{ request()->input('step_progress_range') == '51-75' ?
                                        'selected' : '' }}>51% - 75%</option>
                                    <option value="76-100" {{ request()->input('step_progress_range') == '76-100' ?
                                        'selected' : '' }}>76% - 100%</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>{{ trans('global.host') }}</label>
                                <select class="form-control select2" name="vendor" id="vendor">
                                    <option value="">{{ $vendorname }}</option>

                                </select>
                            </div>


                            

                             <div class="col-md-1 col-sm-12 col-xs-12">
    <label>{{ $currentModule->name }} Name</label>
    <input 
        type="text" 
        class="form-control" 
        name="title" 
        id="title" 
        value="{{ request()->input('title', '') }}" 
        placeholder="Enter {{ $currentModule->name }} Name">
</div>


                            <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">
                                <br>
                                <button type="submit" name="btn" class="btn btn-primary btn-flat filterproduct">{{
                                    trans('global.filter') }}</button>
                                <button type="button" id="resetBtn" class="btn btn-primary btn-flat resetproduct">{{
                                    trans('global.reset') }}</button>
                            </div>

                        </div>

                </div>
                </form>
            </div>

        </div>
        @include('admin.common.liveTrashSwitcher')
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.' . strtolower($title)) }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable  datatable-Booking">
                            <thead>
                                <tr>
                                    <th>

                                    </th>
                                    <th>
                                        {{ trans('global.id') }}#
                                    </th>
                                    <th>
                                            {{ $currentModule->name }} {{ trans('global.name') }}
                                        </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        {{ trans('global.host') }}
                                    </th>
                                    <th>
                                        {{ trans('global.image') }}
                                    </th>
                                    <th>
                                        Document
                                    </th>
                                    <th width="50">
                                        {{ trans('global.price') }}
                                    </th>
                                    <th>
                                        {{ trans('global.place') }}
                                    </th>
                                    <th>
                                        {{ trans('global.verified') }}
                                    </th>
                                    <th>
                                        {{ trans('global.is_featured') }}
                                    </th>
                                    <th>
                                        Step Progress
                                    </th>
                                    <th>
                                        {{ trans('global.status') }}
                                    </th>

                                    <th> {{ trans('global.actions') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $key => $item)
                                <tr data-entry-id="{{$item->id}}">
                                    <td>
                                    </td>
                                    <td>
                                        {{ $item->id ?? '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.vehicles.base', ['id' => $item->id]) }}">
                                            {{ $item->title ?? '' }}
                                        </a>
                                    </td>
                                    <td>{{ $item->item_type ? $item->item_type->name : 'N/A' }}</td>
                                    @php
                                    $userType = $item->userid->user_type ?? 'user'; // default fallback
                                    $routeName = 'admin.vendor.profile';
                                    @endphp

                                    <td>
                                        <a target="_blank"
                                            href="{{ route($routeName, $item->userid_id) }}?user_type={{ $userType }}">
                                            {{ $item->userid->first_name ?? '' }} {{ $item->userid->last_name ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($item->front_image)
                                        <a href="{{ $item->front_image->url}}">
                                            <img src="{{ $item->front_image->thumbnail }}" alt="{{ $item->title }}"
                                                class="item-image-size">
                                        </a>

                                        @endif
                                    </td>

                                    <td>
                                        @if($item->front_image_doc)
                                        <a href="{{ $item->front_image_doc->url}}">
                                            <img src="{{ $item->front_image_doc->thumbnail }}" alt="{{ $item->title }}"
                                                class="item-image-size">
                                        </a>

                                        @endif
                                    </td>
                                    <td>
                                        {{ ($general_default_currency->meta_value ?? '') . ' ' . ($item->price ?? '') }}

                                    </td>
                                    <td>
                                        @php
                                        $parts = [];
                                        if (!empty($item->city_name)) {
                                        $parts[] = $item->city_name;
                                        }
                                        if (!empty($item->state_region)) {
                                        $parts[] = $item->state_region;
                                        }
                                        if (!empty($item->country)) {
                                        $parts[] = $item->country;
                                        }
                                        @endphp

                                        {{ implode(' , ', $parts) }}
                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="{{$item->id}}" class="check isvefifieddata" type="checkbox"
                                                data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" {{
                                                $item->is_verified ? 'checked' : '' }}>
                                            <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="{{$item->id}}" class="check isfeatureddata" type="checkbox"
                                                data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" {{
                                                $item->is_featured ? 'checked' : '' }}>
                                            <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                        $completionPercentage = $item->step_progress ?? 0;
                                        $steps = json_decode($item->steps_completed, true);
                                        if ($steps !== null && is_array($steps)) {
                                        $incompleteSteps = array_keys(array_filter($steps, function ($step) {
                                        return !$step;
                                        }));
                                        }

                                        @endphp

                                        <div class="progress-circle" data-item-id="{{ $item->id }}"
                                            data-incomplete-steps="{{ json_encode($incompleteSteps) }}"
                                            style="background: conic-gradient(#28c76f {{ $completionPercentage }}%, #dd4b39 {{ $completionPercentage }}% 100%);">
                                            <span>{{ round($completionPercentage) }}%</span>
                                        </div>
                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="{{$item->id}}" class="check statusdata" type="checkbox"
                                                data-onstyle="success" id="{{'user' . $i++}}" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" {{
                                                $item->status ? 'checked' : '' }}>
                                            <label for="{{'user' . $j++}}" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->trashed())
                                        <form id="restore-form-{{ $item->id }}"
                                            action="{{ route('admin.common.trash.restore', $item->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            <button type="button" class="btn btn-xs btn-success restore-btn"
                                                data-id="{{ $item->id }}">
                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                            </button>
                                        </form>



                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.common.trash.permanentDelete', $item->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @method('POST')
                                            @csrf
                                            <button type="button" class="btn btn-xs btn-danger permanent-delete"
                                                data-id="{{ $item->id }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form> @else

                                        @can($title . '_edit')
                                        @php
                                        $base = $realRoute;
                                        @endphp

                                        <a style="margin-bottom:5px;margin-top:5px" class="btn btn-xs btn-info"
                                            href="{{ route('admin.' . $base . '.base', ['id' => $item->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        @endcan

                                        @can('title_delete')
                                        <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        @endcan
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                @if ($items->currentPage() > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $items->previousPageUrl() }}" tabindex="-1">
                                        {{ trans('global.previous') }}</a>
                                </li>
                                @else
                                <li class="page-item disabled">
                                    <span class="page-link"> {{ trans('global.previous') }}</span>
                                </li>
                                @endif
                                @for ($i = 1; $i <= $items->lastPage(); $i++)
                                    <li class="page-item {{ $i == $items->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $items->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    @if ($items->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $items->nextPageUrl() }}">
                                            {{ trans('global.next') }}</a>
                                    </li>
                                    @else
                                    <li class="page-item disabled">
                                        <span class="page-link"> {{ trans('global.next') }}</span>
                                    </li>
                                    @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>


@endsection
@section('scripts')
@parent
<script>
    document.addEventListener('DOMContentLoaded', function () {
        handleToggleUpdate(
            '.statusdata',
            '{{ route("admin.update-item-status") }}',
            'status',
            {
                title: '{{ trans("global.are_you_sure") }}',
                text: '{{ trans("global.update_status_confirmation") }}',
                confirmButtonText: '{{ trans("global.yes_continue") }}',
                cancelButtonText: '{{ trans("global.cancel") }}'
            }
        );

        handleToggleUpdate(
            '.isvefifieddata',
            '{{ route("admin.update-item-verified") }}',
            'isverified',
            {
                title: '{{ trans("global.are_you_sure") }}',
                text: '{{ trans("global.update_status_confirmation") }}',
                confirmButtonText: '{{ trans("global.yes_continue") }}',
                cancelButtonText: '{{ trans("global.cancel") }}'
            }
        );

        handleToggleUpdate(
            '.isfeatureddata',
            '{{ route("admin.update-item-featured") }}',
            'featured',
            {
                title: '{{ trans("global.are_you_sure") }}',
                text: '{{ trans("global.update_status_confirmation") }}',
                confirmButtonText: '{{ trans("global.yes_continue") }}',
                cancelButtonText: '{{ trans("global.cancel") }}'
            }
        );
        attachIncompleteStepTooltips();
        attachDeleteButtons(
            '{{ $realRoute }}',
            {
                title: '{{ trans("global.are_you_sure") }}',
                text: '{{ trans("global.you_able_revert_this") }}',
                icon: 'warning',
                confirmButtonText: '{{ trans("global.yes_continue") }}',
                cancelButtonText: '{{ trans("global.cancel") }}'
            }
        );

        attachFilterResetButton('#itemFilterForm', ['#vendor', '#type']);


    });
    $(document).ready(function () {
   attachRestoreOrDeleteButtons('.restore-btn', {
                title: "Restore Vehicle",
                text: "Are you sure you want to restore this vehicle?",
                confirmButtonText: "Yes, restore it!",
                processingTitle: "Restoring",
                processingText: "Please wait while restoring...",
                successMessage: "Booking restored successfully!",
                errorMessage: "An error occurred while restoring the vehicle."
            });

            attachRestoreOrDeleteButtons('.permanent-delete', {
                title: "Delete Vehicle Permanently",
                text: "Are you sure you want to permanently delete this vehicle?",
                confirmButtonText: "Yes, delete it!",
                processingTitle: "Deleting",
                processingText: "Please wait while deleting...",
                successMessage: "Booking permanently deleted!",
                errorMessage: "An error occurred while deleting the vehicle."
            });

        attachAjaxSelect(
            '#type',
            '{{ route("admin.typeSearch") }}',
            item => ({ id: item.id, text: item.name }),
            @json(isset($typeId) ? ['id' => $typeId, 'text' => $typeName] : null)
        );

        attachAjaxSelect(
            '#vendor',
            '{{ route("admin.searchcustomer") }}',
            item => ({ id: item.id, text: item.first_name }),
            @json(isset($vendorId) ? ['id' => $vendorId, 'text' => $vendorname] : null),
            { data_type: 'host' }
        );
          

        let deleteRoute = "{{ route('admin.delete.rows') }}";
        if (window.location.href.indexOf('trash') !== -1) {
            deleteRoute = "{{ route('admin.trash-delete.rows') }}";
        }
        attachBulkDeleteButton({
            datatableSelector: '.datatable-Booking:not(.ajaxTable)',
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

    });
</script>


@endsection