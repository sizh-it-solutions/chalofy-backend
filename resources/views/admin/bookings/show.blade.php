@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <!-- Order Details Section -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading d-flex justify-content-between align-items-center">
                        <span>{{ trans('booking.booking_details') }}</span>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> {{ trans('booking.back_to_bookings') }}
                        </a>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped">

                            <tr>
                                <th class="icon-header">
                                    {{ trans('booking.reservation_code') }}
                                </th>
                                <td>
                                    <span class="badge badge-pill badge-primary live-badge">
                                        <i class="fas fa-database table-icon"></i>
                                        {{ $bookingData->token }}
                                    </span>

                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    {{ trans('booking.booking_date') }}
                                </th>
                                <td>
                                    <span class="badge badge-pill badge-info">
                                        <i class="far fa-clock table-icon"></i>
                                        {{ \Carbon\Carbon::parse($bookingData->created_at)->format('h:i A, Y-m-d') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    {{ trans('booking.vehicle') }}
                                </th>
                                <td class="data-cell">
                                    <span class="badge badge-pill badge-primary live-badge">
                                        <i class="fas fa-car-side table-icon"></i>
                                        {{ $bookingData->item->title ?? '-' }}
                                    </span>

                                </td>

                            </tr>

                            <tr>
                                <th class="icon-header">
                                    {{ trans('booking.start') }}
                                </th>
                                <td>

                                    {{ $bookingData->check_in ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    {{ trans('booking.end') }}
                                </th>
                                <td>

                                    {{$bookingData->check_out ?? '-' }}
                                </td>
                            </tr>


                            <tr>
                                <th class="icon-header">
                                    <i class="fas fa-traffic-light table-icon animate-bounce"></i>
                                    {{ trans('booking.booking_status') }}
                                </th>
                                <td>
                                    <strong>
                                        @if ($bookingData->status === 'Ongoing')
                                            <span class="badge badge-pill label-secondary live-badge">
                                                <span class="live-dot"></span> {{ trans('booking.booking_live') }}
                                            </span>
                                        @elseif ($bookingData->status === 'Cancelled')
                                            <span class="badge badge-pill badge-danger">
                                                {{ trans('booking.booking_cancelled') }}</span>
                                        @elseif ($bookingData->status === 'Accepted')
                                            <span class="badge badge-pill badge-success">
                                                {{ trans('booking.booking_accepted') }} </span>
                                        @elseif ($bookingData->status === 'Approved')
                                            <span
                                                class="badge badge-pill badge-success">{{ trans('booking.booking_approved') }}</span>
                                        @elseif ($bookingData->status === 'Rejected')
                                            <span
                                                class="badge badge-pill badge-warning">{{ trans('booking.booking_rejected') }}</span>
                                        @elseif ($bookingData->status === 'Completed')
                                            <span
                                                class="badge badge-pill badge-info">{{ trans('booking.booking_completed') }}</span>
                                        @elseif ($bookingData->status === 'Refunded')
                                            <span
                                                class="badge badge-pill badge-primary">{{ trans('booking.booking_refunded') }}</span>
                                        @elseif ($bookingData->status === 'Confirmed')
                                            <span
                                                class="badge badge-pill badge-success">{{ trans('booking.booking_confirmed') }}</span>
                                        @else
                                            {{ $bookingData->status }}
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @if ($bookingData->status === 'Cancelled' || $bookingData->status === 'Declined')
                                <tr>
                                    <th class="icon-header">
                                        <i class="fas fa-exclamation-circle table-icon"></i>
                                        {{ trans('booking.cancellation_reasion') }}
                                    </th>
                                    <td>{{ $bookingData->cancellation_reasion }}</td>
                                </tr>
                            @endif

                        </table>


                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('booking.payments_details') }}
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.payment_method') }}
                                </th>
                                <td>
                                    @php
                                        $paymentMethod = strtolower($bookingData->payment_method) ?? '';
                                        $badgeClass = match ($paymentMethod) {
                                            'cash' => 'badge badge-pill label-secondary',
                                            'card', 'credit card', 'debit card' => 'badge badge-pill label-primary',
                                            'paypal' => 'badge badge-pill badge-info',
                                            'stripe' => 'badge badge-pill label-warning',
                                            'wallet' => 'badge badge-pill label-success',
                                            default => 'badge badge-pill label-light',
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }} badge-custom">
                                        <i class="fas fa-credit-card table-icon"></i>
                                        {{ ucfirst($paymentMethod) }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.payment_status') }}
                                </th>
                                <td>
                                    @if ($bookingData->payment_status === 'paid')
                                        <span class="badge badge-pill label-success badge-custom">
                                            <i class="fas fa-check-circle table-icon"></i> Paid
                                        </span>
                                    @elseif ($bookingData->payment_status === 'notpaid')
                                        <span class="badge badge-pill label-danger badge-custom">
                                            <i class="fas fa-clock table-icon"></i> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.ride_fare') }}
                                </th>
                                <td>{{ (formatCurrency($bookingData->total) ?? '-') . ' ' . (Config::get('general.general_default_currency') ?? '') }}</td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.admin_commission') }}
                                </th>
                                <td>{{ formatCurrency($bookingData->bookingFinance->admin_commission) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.security_money') }}
                                </th>
                                <td>{{ formatCurrency($bookingData->bookingFinance->doorstep_price) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.doot_step_prince') }}
                                </th>
                                <td>{{ formatCurrency($bookingData->bookingFinance->security_money) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}</td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.iva_tax') }}
                                </th>
                                <td>{{ formatCurrency($bookingData->bookingFinance->iva_tax) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}</td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.vendor_income') }}
                                </th>
                                <td>{{formatCurrency($bookingData->bookingFinance->vendor_commission) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}
                                </td>
                            </tr>  @if ($bookingData->status === 'Cancelled' || $bookingData->status === 'Declined' )
                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.refund_amount') }}
                                </th>
                                <td>{{formatCurrency($bookingData->bookingFinance->refundableAmount) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-heading">
                                    {{ trans('booking.deduct_amount') }}
                                </th>
                                <td>{{formatCurrency($bookingData->bookingFinance->deductedAmount) ?? '-' }}
                                    {{ Config::get('general.general_default_currency') ?? '' }}
                                </td>
                            </tr>
                            @endif
                            @if (!empty($bookingData->transaction))
                                <tr>
                                    <th class="table-heading">
                                        <i class="fas fa-barcode table-icon"></i>
                                        {{ trans('booking.transaction_id') }}
                                    </th>
                                    <td>
                                        <span class="badge badge-pill badge-dark badge-custom">
                                            {{ $bookingData->transaction }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        </table>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('booking.user_details') }}
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2" class="text-center">
                                    @if ($bookingData->user)
                                        <a target="_blank"
                                            href="{{ route('admin.customer.profile', ['id' => $bookingData->user->id]) }}">
                                            @if ($bookingData->user->profile_image)
                                                <img src="{{ $bookingData->user->profile_image->getUrl('thumb') }}"
                                                    class="img-circle_details">
                                            @else
                                                <img src="{{ asset('public/images/icon/userdefault.jpg') }}" alt="Default Image"
                                                    class="img-circle_details">
                                            @endif
                                        </a>

                                        @php
                                            $rating = $bookingData->user->avr_guest_rate ?? null;
                                        @endphp
                                        @if ($rating)
                                            <div class="host-rating mt-1">
                                                <span class="badge badge-warning">
                                                    ⭐ {{ number_format($rating, 1) }}/5
                                                </span>
                                            </div>
                                        @else
                                            <div class="host-rating mt-1">
                                                <span class="text-muted">No rating</span>
                                            </div>
                                        @endif
                                    @else
                                        <span>--</span>
                                    @endif
                                </th>
                            </tr>

                            <tr>
                                <th>{{ trans('booking.name') }}</th>
                                <td>{{ $bookingData->user->first_name ?? '' }} {{ $bookingData->user->last_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('booking.email') }}</th>
                                <td>{{ $bookingData->user->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('booking.phone') }}</th>
                                <td>{{ $bookingData->user->phone_country ?? '' }} {{ $bookingData->user->phone ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('booking.vendor_details') }}
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2" class="text-center">
                                    @if ($bookingData->host)
                                        <a target="_blank"
                                            href="{{ route('admin.vendor.profile', ['id' => $bookingData->host->id]) }}">
                                            @if ($bookingData->host->profile_image)
                                                <img src="{{ $bookingData->host->profile_image->getUrl('thumb') }}"
                                                    class="img-circle_details mb-2">
                                            @else
                                                <img src="{{ asset('public/images/icon/userdefault.jpg') }}" alt="Default Image"
                                                    class="img-circle_details mb-2">
                                            @endif
                                        </a>
                                        @php
                                            $rating = $bookingData->host->ave_host_rate ?? null;
                                        @endphp
                                        @if ($rating)
                                            <div class="host-rating mt-1">
                                                <span class="badge badge-warning">
                                                    ⭐ {{ number_format($rating, 1) }}/5
                                                </span>
                                            </div>
                                        @else
                                            <div class="host-rating mt-1">
                                                <span class="text-muted">No rating</span>
                                            </div>
                                        @endif
                                    @else
                                        <span>--</span>
                                    @endif
                                </th>


                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('booking.name') }}</th>
                                <td>{{ $bookingData->host->first_name ?? '' }} {{ $bookingData->user->last_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('booking.email') }}</th>
                                <td>{{ $bookingData->host->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('booking.phone') }}</th>
                                <td>{{ $bookingData->host->phone_country ?? '' }} {{ $bookingData->host->phone ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection