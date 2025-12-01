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
                                        <option value="pending" {{ request()->input('status') === 'pending' ? 'selected' :
        '' }}>Pending
                                        </option>
                                        <option value="confirmed" {{ request()->input('status') === 'confirmed' ? 'selected'
        : '' }}>Confirmed
                                        </option>
                                        <option value="cancelled" {{ request()->input('status') === 'cancelled' ? 'selected'
        : '' }}>Cancelled
                                        </option>
                                        <option value="declined" {{ request()->input('status') === 'declined' ? 'selected' :
        '' }}>Declined
                                        </option>
                                        <option value="completed" {{ request()->input('status') === 'completed' ? 'selected'
        : '' }}>Completed
                                        </option>
                                        <option value="refunded" {{ request()->input('status') === 'refunded' ? 'selected' :
        '' }}>Refunded
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">

                                    <button type="submit" name="btn" class="btn btn-primary btn-flat">{{
        trans('global.filter') }}</button>
                                    <button type="button" name="reset_btn" id="resetBtn" class="btn btn-primary btn-flat">{{
        trans('global.reset') }}</button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        @php
                            $currency = (Config::get('general.general_default_currency') ?? '');
                        @endphp
                        <div class="row">
                            {{-- Row 1 --}}
                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ $totalBookings ?? 0 }}</h2>
                                        <p class="text-muted">{{ trans('global.total_bookings') }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ formatCurrency($totalEarnings) . ' ' . $currency }}</h2>
                                        <p class="text-muted">{{ trans('global.totalEarning') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ formatCurrency($totalAdminCommission) . ' ' . $currency }}
                                        </h2>
                                        <p class="text-muted">{{ trans('global.admin_commission') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Spacer between rows --}}
                            <div class="clearfix visible-md-block visible-lg-block" style="margin-bottom: 15px;"></div>

                            {{-- Row 2 --}}
                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ formatCurrency($totalVendorCommission) . ' ' . $currency }}
                                        </h2>
                                        <p class="text-muted">{{ trans('global.vendor_commission') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ formatCurrency($totalRefunded) . ' ' . $currency }}</h2>
                                        <p class="text-muted">{{ trans('global.refunded') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin">{{ formatCurrency($total_security_money) . ' ' . $currency }}
                                        </h2>
                                        <p class="text-muted">{{ trans('global.total_security') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
                                            {{ trans('global.admin_commission') }}
                                        </th>
                                        <th>
                                            {{ trans('global.vendor_commission') }}
                                        </th>
                                        <th>
                                            {{ trans('global.iva_tax') }}
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
                                            {{ trans('global.action') }}
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                                                <tr data-entry-id="{{ $booking->id }}">
                                                                    <td>

                                                                    </td>
                                                                    <td>
                                                                        @if ($booking->item)
                                                                            <a target="_blank" class="btn btn-xs btn-primary"
                                                                                href="{{ route('admin.bookings.show', $booking->id) }}">
                                                                                {{ $booking->token }}</a>
                                                                        @else
                                                                            {{ $booking->token }}
                                                                        @endif
                                                                    </td>
                                                                    <td>

                                                                        @php
                                                                            $itemData = json_decode($booking->item_data, true);
                                                                            $itemName = $itemData[0]['name'] ?? ($booking->item_title ?? '');
                                                                        @endphp

                                                                        @if ($booking->item && $booking->module == 2)
                                                                            <a target="_blank" href="{{ route('admin.vehicles.base', $booking->itemid) }}">
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
                                                                        @if (($booking->payment_method ?? '') === 'offline')
                                                                            💵 Cash
                                                                        @else
                                                                            💳 Card/Online
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ (formatCurrency($booking->total) ?? '') . ' ' . (Config::get('general.general_default_currency') ?? '')
                                                                                                                                                                                                        }}
                                                                    </td>

                                                                    <td>
                                                          {{ (formatCurrency(optional($booking->bookingFinance)->admin_commission) ?? '0') . ' ' . (Config::get('general.general_default_currency') ?? '') }}


                                                                    </td>


                                                                    <td>
                                                                  {{ formatCurrency(optional($booking->bookingFinance)->vendor_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}

                                                                    </td>

                                                                    <td>
                                                                      {{
    formatCurrency(optional($booking->bookingFinance)->iva_tax ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')
}}
<br />

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
                                                                        @else
                                                                            {{ $booking->status }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($booking->payment_status === 'paid')
                                                                            <span class="badge badge-pill label-success">paid</span>
                                                                        @elseif ($booking->payment_status === 'notpaid')
                                                                            <span class="badge badge-pill label-danger">notpaid</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-xs btn-primary btn-flat view-details-btn"
    data-token="{{ $booking->token ?? '' }}"
    data-token_url="{{ route('admin.bookings.show', $booking->id) }}"
    data-item="{{ $itemName ?? '' }}"
    data-item_url="@if($booking->item && $booking->module == 2){{ route('admin.vehicles.base', $booking->itemid) }}@endif"
    data-host="{{ $booking->host ? $booking->host->first_name . ' ' . $booking->host->last_name : '--' }}"
    data-host_url="{{ $booking->host ? route('admin.vendor.profile', $booking->host->id) : '' }}"
    data-user="{{ $booking->user ? $booking->user->first_name . ' ' . $booking->user->last_name : '--' }}"
    data-user_url="{{ $booking->user ? route('admin.customer.profile', $booking->user->id) : '' }}"
    data-payment_method="{{ ($booking->payment_method ?? '') === 'offline' ? 'Cash' : 'Card/Online' }}"
    data-total="{{ formatCurrency($booking->total ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-admin_commission="{{ formatCurrency(optional($booking->bookingFinance)->admin_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-vendor_commission="{{ formatCurrency(optional($booking->bookingFinance)->vendor_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-ivat="{{ formatCurrency(optional($booking->bookingFinance)->iva_tax ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-doorstep="{{ formatCurrency(optional($booking->bookingFinance)->doorstep_price ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-security="{{ formatCurrency(optional($booking->bookingFinance)->security_money ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-refundableAmount="{{ formatCurrency(optional($booking->bookingFinance)->refundableAmount ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-deductedAmount="{{ formatCurrency(optional($booking->bookingFinance)->deductedAmount ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '') }}"
    data-booking_date="{{ $booking->created_at ? $booking->created_at->format('Y-m-d') : '' }}"
    data-status="{{ strtoupper($booking->status) ?? '' }}"
    data-payment_status="{{ strtoupper($booking->payment_status) ?? '' }}">
    View
</button>

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
                                                                    <a class="page-link" href="{{ $bookings->previousPageUrl() }}" tabindex="-1">{{
                                        trans('global.previous') }}</a>
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
                                                                    <a class="page-link" href="{{ $bookings->nextPageUrl() }}">{{
                                        trans('global.next') }}</a>
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
    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="detailsModalLabel">Booking Financial Details</h4>
                </div>
                <div class="modal-body" id="detailsModalBody">
                    <!-- Details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            attachFilterResetButton('#bookingFilterForm', ['#customer', '#host', '#item', '#status',
                '#daterange-btn'
            ]);


        });

        $(document).ready(function () {



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
    <script>
        $(document).ready(function () {
            $('.view-details-btn').click(function () {
                var data = $(this).data();

                function linkedField(name, value, url) {
                    if (url) {
                        return `<tr><td><strong>${name}</strong></td><td><a href="${url}" target="_blank">${value}</a></td></tr>`;
                    } else {
                        return `<tr><td><strong>${name}</strong></td><td>${value}</td></tr>`;
                    }
                }

                var html = `
                            <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <tbody>
                                    ${linkedField('Booking ID', data.token ?? '-', data.token_url ?? '')}
                                    ${linkedField('Item Name', data.item ?? '-', data.item_url ?? '')}
                                    ${linkedField('Host', data.host ?? '-', data.host_url ?? '')}
                                    ${linkedField('User', data.user ?? '-', data.user_url ?? '')}
                                    <tr><td><strong>Payment Method</strong></td><td>${data.payment_method ?? '-'}</td></tr>
                                    <tr><td><strong>Total</strong></td><td>${data.total ?? '-'}</td></tr>
                                    <tr><td><strong>Admin Commission</strong></td><td>${data.admin_commission ?? '-'}</td></tr>
                                    <tr><td><strong>Vendor Commission</strong></td><td>${data.vendor_commission ?? '-'}</td></tr>
                                    <tr><td><strong>IVA Tax</strong></td><td>${data.ivat ?? '-'}</td></tr>
                                    <tr><td><strong>Doorstep Price</strong></td><td>${data.doorstep ?? '-'}</td></tr>
                                    <tr><td><strong>Security Money</strong></td><td>${data.security ?? '-'}</td></tr>
                                    <tr><td><strong>Booking Date</strong></td><td>${data.booking_date ?? '-'}</td></tr>
                                    <tr><td><strong>Status</strong></td><td>${data.status ?? '-'}</td></tr>
                                    <tr><td><strong>Payment Status</strong></td><td>${data.payment_status ?? '-'}</td></tr>
                                     <tr><td><strong>refundableamount</strong></td><td>${data.refundableamount ?? '-'}</td></tr>
                                      <tr><td><strong>deductedAmount</strong></td><td>${data.deductedAmount ?? '-'}</td></tr>
                                      </tbody>
                            </table>
                            </div>
                        `;

                $('#detailsModalBody').html(html);
                $('#detailsModal').modal('show');
            });
        });
    </script>




@endsection