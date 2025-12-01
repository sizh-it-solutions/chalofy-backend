@extends('layouts.admin')

@section('content')
    @php
        $i = 0;
        $j = 0;
    @endphp
    <div class="content">
        <div class="row">

            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET"
                            accept-charset="UTF-8" id="bookingFilterForm">

                            <div class="col-md-12 d-none">
                                <input class="form-control" type="hidden" id="startDate" name="from" value="">
                                <input class="form-control" type="hidden" id="endDate" name="to" value="">
                            </div>


                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label>{{ trans('global.date_range') }}</label>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control" id="daterange-btn" autocomplete="off">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label>{{ $currentModule->name }} Name</label>
                                    <select class="form-control select2" name="item" id="item">
                                        <option value="">{{ $searchfieldItem }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label> {{ trans('global.customer') }} </label>
                                    <select class="form-control select2" name="customer" id="customer">
                                        <option value="">{{ $searchCustomer }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label> {{ trans('global.host') }} </label>
                                    <select class="form-control select2" name="host" id="host">
                                        <option value="">{{ $vendorName }}</option>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label>{{ trans('global.status') }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">Please Select Status </option>
                                        <option value="pending" {{ request()->input('status') === 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="confirmed"
                                            {{ request()->input('status') === 'confirmed' ? 'selected' : '' }}>Confirmed
                                        </option>
                                        <option value="cancelled"
                                            {{ request()->input('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                        <option value="declined"
                                            {{ request()->input('status') === 'declined' ? 'selected' : '' }}>Declined
                                        </option>
                                        <option value="completed"
                                            {{ request()->input('status') === 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="refunded"
                                            {{ request()->input('status') === 'refunded' ? 'selected' : '' }}>Refunded
                                        </option>
                                        <option value="live"
                                            {{ request()->input('status') === 'live' ? 'selected' : '' }}>Live
                                        </option>
                                        <option value="paymentFailed"
                                            {{ request()->input('status') === 'paymentFailed' ? 'selected' : '' }}>PaymentFailed
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">

                                    <button type="submit" name="btn"
                                        class="btn btn-primary btn-flat">{{ trans('global.filter') }}</button>
                                    <button type="button" name="reset_btn" id="resetBtn"
                                        class="btn btn-primary btn-flat">{{ trans('global.reset') }}</button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span class="text-20"> {{ $totalBookings }}</span><br>
                                        <span
                                            class="font-weight-bold total-book">{{ trans('global.total_bookings') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span class="text-20">{{ $totalCustomers }}</span><br>
                                        <span
                                            class="font-weight-bold total-customer">{{ trans('global.total_customers') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span
                                            class="text-20">{{ formatCurrency($totalEarnings) . ' ' . (Config::get('general.general_default_currency') ?? '') }}</span><br>
                                        <span class="font-weight-bold total-amount">{{ trans('global.totalEarning') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span
                                            class="text-20">{{ formatCurrency($totalRefunded) . ' ' . (Config::get('general.general_default_currency') ?? '') }}</span><br>
                                        <span class="font-weight-bold total-amount">{{ trans('global.totalRefund') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row" style="margin-left: 5px; margin-bottom: 6px;">
                <div class="col-lg-12">
                    <a class="{{ request()->routeIs('admin.bookings.index') && !request()->query('status') ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index') }}">
                        {{ trans('global.live') }}
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['live'] > 0 ? $statusCounts['live'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'pending' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
                        Pending
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['pending'] > 0 ? $statusCounts['pending'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'confirmed' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">
                        Confirmed
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['confirmed'] > 0 ? $statusCounts['confirmed'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'cancelled' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">
                        Cancelled
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['cancelled'] > 0 ? $statusCounts['cancelled'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'declined' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'declined']) }}">
                        Declined
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['declined'] > 0 ? $statusCounts['declined'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'completed' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">
                        Completed
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['completed'] > 0 ? $statusCounts['completed'] : 0 }}</span>
                    </a>

                    <a class="{{ request()->query('status') === 'refunded' ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.index', ['status' => 'refunded']) }}">
                        Refunded
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['refunded'] > 0 ? $statusCounts['refunded'] : 0 }}</span>
                    </a>


                    <a class="{{ request()->routeIs('admin.bookings.trash') ? 'btn btn-primary' : 'btn btn-inactive' }}"
                        href="{{ route('admin.bookings.trash') }}">
                        {{ trans('global.trash') }}
                        <span
                            class="badge badge-pill badge-primary">{{ $statusCounts['trash'] > 0 ? $statusCounts['trash'] : 0 }}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.booking_title_singular_list') }}
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                                <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                            {{ trans('global.id') }}
                                        </th>
                                        <th>
                                            {{ $currentModule->name }} {{ trans('global.name') }}
                                        </th>
                                        <th>
                                            {{ trans('global.host') }}
                                        </th>
                                        <th>
                                            {{ trans('global.user_title_singular') }}
                                        </th>
                                        <th>
                                            {{ trans('global.payment_method') }}
                                        </th>
                                        <th>
                                            {{ trans('global.total') }}
                                        </th>
                                        <th>
                                            {{ trans('global.booking_date') }}
                                        </th>
                                        <th>
                                            {{ trans('global.status') }}
                                        </th>
                                        <th>
                                            {{ trans('global.payment_status') }}
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                        <tr data-entry-id="{{ $booking->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{-- @if ($booking->item) --}}
                                                    <a target="_blank" class="btn btn-xs btn-primary"
                                                        href="{{ route('admin.bookings.show', $booking->id) }}">
                                                        {{ $booking->token }}</a>
                                               {{-- @else
                                                    {{ $booking->token }}
                                                @endif --}}
                                            </td>
                                            <td>

                                                @php
                                                    $itemData = json_decode($booking->item_data, true);
                                                    $itemName = $itemData[0]['name'] ?? ($booking->item_title ?? '');
                                                @endphp

                                                @if ($booking->item && $booking->module == 2)
                                                    <a target="_blank"
                                                        href="{{ route('admin.vehicles.base', $booking->itemid) }}">
                                                        {{ $itemName }}
                                                    </a>
                                                @else
                                                    {{ $itemName }}
                                                @endif


                                            </td>
                                           

                                            <td>
                                                @if ($booking->host)
                                                    <a target="_blank"
                                                        href="{{ route('admin.vendor.profile', $booking->host->id) }}">
                                                        {{ $booking->host->first_name }} {{ $booking->host->last_name }}
                                                    </a>
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>


                                            <td>
                                                @if ($booking->user)
                                                    <a target="_blank"
                                                        href="{{ route('admin.customer.profile', $booking->user->id) }}">
                                                        {{ $booking->user->first_name ?? '' }}
                                                        {{ $booking->user->last_name ?? '' }}
                                                    </a>
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $booking->payment_method ?? '' }}
                                            </td>
                                            <td>
                                                {{ (formatCurrency($booking->total) ?? '') . ' ' . (Config::get('general.general_default_currency')?? '') }}
                                            </td>
                                            <td>
                                                {{ $booking->created_at ? $booking->created_at->format('Y-m-d') : '' }}
                                            </td>

                                            <td>
                                                @if ($booking->status === 'Pending')
                                                    <span class="badge badge-pill label-secondary">Pending</span>
                                                @elseif ($booking->status === 'Cancelled')
                                                    <span class="badge badge-pill label-danger">Cancelled</span>
                                                @elseif ($booking->status === 'Approved')
                                                    <span class="badge badge-pill label-success">Approved</span>
                                                @elseif ($booking->status === 'Declined')
                                                    <span class="badge badge-pill label-warning">Declined</span>
                                                @elseif ($booking->status === 'Completed')
                                                    <span class="badge badge-pill label-info">Completed</span>
                                                @elseif ($booking->status === 'Refunded')
                                                    <span class="badge badge-pill label-primary">Refunded</span>
                                                @elseif ($booking->status === 'Confirmed')
                                                    <span class="badge badge-pill label-success">Confirmed</span>
                                                @elseif ($booking->status === 'PaymentFailed')
                                                <span class="badge badge-pill label-danger">PaymentFailed</span>
                                                @elseif ($booking->status === 'Live')
                                                <span class="badge badge-pill label-info">Live</span>
                                                @else
                                                    {{ $booking->status }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($booking->payment_status === 'paid')
                                                    <span class="badge badge-pill label-success">paid</span>
                                                @elseif ($booking->payment_status === 'notpaid')
                                                    <span class="badge badge-pill label-danger">notpaid</span>
                                                @elseif ($booking->payment_status === 'failed')
                                                    <span class="badge badge-pill label-danger">Failed</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($booking->trashed())
                                                    {{-- Restore Button --}}
                                                    <form id="restore-form-{{ $booking->id }}"
                                                        action="{{ route('admin.bookings.restore', $booking->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <button type="button" class="btn btn-xs btn-success restore-btn"
                                                            data-id="{{ $booking->id }}">
                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                        </button>
                                                    </form>

                                                    {{-- Permanent Delete Button --}}
                                                    <form id="delete-form-{{ $booking->id }}"
                                                        action="{{ route('admin.bookings.permanentDelete', $booking->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="button"
                                                            class="btn btn-xs btn-danger permanent-delete"
                                                            data-id="{{ $booking->id }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Soft Delete Button --}}
                                                    @can('booking_delete')
                                                        <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                                            data-id="{{ $booking->id }}">
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
                                    {{-- Previous Page Link --}}
                                    @if ($bookings->currentPage() > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $bookings->previousPageUrl() }}"
                                                tabindex="-1">{{ trans('global.previous') }}</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">{{ trans('global.previous') }}</span>
                                        </li>
                                    @endif

                                    {{-- Numeric Pagination Links --}}
                                    @for ($i = 1; $i <= $bookings->lastPage(); $i++)
                                        <li class="page-item {{ $i == $bookings->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $bookings->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($bookings->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $bookings->nextPageUrl() }}">{{ trans('global.next') }}</a>
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
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            attachFilterResetButton('#bookingFilterForm', ['#customer', '#host', '#item', '#status',
                '#daterange-btn'
            ]);
            attachDeleteButtons('bookings', {
                title: '{{ trans('global.are_you_sure') }}',
                text: '{{ trans('global.delete_confirmation') }}',
                confirmButtonText: '{{ trans('global.yes_delete_it') }}',
                cancelButtonText: '{{ trans('global.cancel') }}',
            });

        });

        $(document).ready(function() {
            attachRestoreOrDeleteButtons('.restore-btn', {
                title: "Restore Booking",
                text: "Are you sure you want to restore this booking?",
                confirmButtonText: "Yes, restore it!",
                processingTitle: "Restoring",
                processingText: "Please wait while restoring...",
                successMessage: "Booking restored successfully!",
                errorMessage: "An error occurred while restoring the booking."
            });

            attachRestoreOrDeleteButtons('.permanent-delete', {
                title: "Delete Booking Permanently",
                text: "Are you sure you want to permanently delete this booking?",
                confirmButtonText: "Yes, delete it!",
                processingTitle: "Deleting",
                processingText: "Please wait while deleting...",
                successMessage: "Booking permanently deleted!",
                errorMessage: "An error occurred while deleting the booking."
            });

            let deleteRoute = "{{ route('admin.bookings.deleteAll') }}";
        if (window.location.href.indexOf('trash') !== -1) {
            deleteRoute = "{{ route('admin.bookings.deleteTrashAll') }}";
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


            attachAjaxSelect(
                '#host',
                '{{ route('admin.searchcustomer') }}',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                @json(isset($vendorId) ? ['id' => $vendorId, 'text' => $vendorName] : null), {
                    data_type: 'vendor'
                }
            );

            attachAjaxSelect(
                '#customer',
                '{{ route('admin.searchcustomer') }}',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                @json(isset($vendorId) ? ['id' => $searchCustomerId, 'text' => $searchCustomer] : null), {
                    data_type: 'user'
                }
            );

            attachAjaxSelect(
                '#item',
                '{{ route('admin.searchItem') }}',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                @json(isset($vendorId) ? ['id' => $searchfieldItemId, 'text' => $searchfieldItem] : null), {
                    data_type: 'user'
                }
            );
        });
    </script>
@endsection
