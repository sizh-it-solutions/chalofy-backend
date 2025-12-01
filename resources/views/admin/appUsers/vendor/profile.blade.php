@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/user-profile.css') }}?{{ time() }}">
@endsection
@section('content')
<div class="content container-fluid">
    @include('admin.appUsers.vendor.menu')

    <div class="driver-profile-page">
        <div class="profile-container">

            <div class="sections-container">
                <div class="section">
                    <div class="avatar-section">


                        <div class="custom-toggle mb-5">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle text-danger"></i> Booking Disabled
                                </span>

                                <label class="switch">
                                    <input type="checkbox" data-id="{{$appUser->id}}" class="hoststatusdata"
                                        name="hoststatusdata" {{ $appUser->host_status ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>

                                <span class="text-sm font-bold text-green-600 flex items-center gap-1">
                                    <i class="fas fa-check-circle text-success"></i>Booking Enabled
                                </span>
                            </div>
                        </div>




                        @if ($appUser->profile_image)
                        <a href="{{ $appUser->profile_image->getUrl() }}" target="_blank">
                            <img src="{{ $appUser->profile_image->getUrl('preview') }}" alt="Profile Image">
                        </a>
                        @else
                        <div class="avatar"></div>
                        @endif
                        <h1 class="profile-name">{{ $appUser->first_name }} {{ $appUser->last_name }}</h1>
                        <div class="profile-username">#{{ $appUser->id }}</div>


                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title">{{ trans('user.booking_information') }}</h3>
                    <div class="vehicle-card grid-layout">
                        @php
                        $baseBookingUrl = url('admin/bookings');
                        $bookingStats = [
                        ['label' => trans('user.pending_booking'), 'key' => 'pending_bookings', 'status' => 'pending'],
                        ['label' => trans('user.confirmed_booking'), 'key' => 'confirmed_bookings', 'status' =>
                        'confirmed'],
                        ['label' => trans('user.cancelled_bookings'), 'key' => 'cancelled_bookings', 'status' =>
                        'cancelled'],
                        ['label' => trans('user.decline_bookings'), 'key' => 'declined_bookings', 'status' =>
                        'declined'],
                        ['label' => trans('user.completed_bookings'), 'key' => 'completed_bookings', 'status' =>
                        'completed'],
                        ['label' => trans('user.total_bookings'), 'key' => 'total_bookings', 'status' => null],
                        ];
                        @endphp
                        @foreach ($bookingStats as $stat)
                        @php
                        $queryParams = [
                        'from' => '',
                        'to' => '',
                        'customer' => '',
                        'host' => $appUser->id,
                        'status' => $stat['status'],
                        'btn' => ''
                        ];
                        $statUrl = $baseBookingUrl . '?' . http_build_query($queryParams);
                        @endphp


                        <div class="info-item">
                            <span class="info-label">
                                <a href="{{ $statUrl }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $stat['label'] }}:
                                </a>
                            </span>
                            <span class="info-value">{{ $data[$stat['key']] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title">{{ trans('user.today_earnings') }}</h3>
                    <div class="vehicle-card grid-layout">
                        @php
                        $currency = Config::get('general.general_default_currency') ?? '';
                        $earnings = [
                        ['label' => trans('user.today_earnings'), 'key' => 'today_earnings'],
                        ['label' => trans('user.admin_commission'), 'key' => 'admin_commission'],
                        ['label' => trans('user.vendor_earnings'), 'key' => 'driver_earnings'],
                        ['label' => trans('user.by_cash'), 'key' => 'cash_earnings'],
                        ['label' => trans('user.by_card_online'), 'key' => 'online_earnings'],
                        ];
                        @endphp
                        @foreach ($earnings as $earning)
                        <div class="info-item">
                            <span class="info-label">{{ $earning['label'] }}:</span>
                            <span class="info-value">{{ formatCurrency($data[$earning['key']] ?? 0) }}
                                {{ $currency }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title">{{ trans('user.personal_information') }}</h3>
                    <div class="vehicle-card grid-layout">
                        @php
                        $personalInfo = [
                        ['label' => trans('user.name'), 'value' => $appUser->first_name . ' ' . $appUser->last_name],

                        // Email with permission check
                        [
                        'label' => trans('user.email'),
                        'value' => auth()->user()->can('app_user_contact_access')
                        ? $appUser->email
                        : maskEmail($appUser->email)
                        ],

                        // Phone with permission check
                        [
                        'label' => trans('user.mobile_number'),
                        'value' => auth()->user()->can('app_user_contact_access')
                        ? ($appUser->phone_country . $appUser->phone)
                        : ($appUser->phone
                        ? $appUser->phone_country . substr($appUser->phone, 0, -6) . str_repeat('*', 6)
                        : ''
                        )
                        ],

                        ['label' => trans('user.gender'), 'value' => $appUser->gender ?? trans('user.unknown')],
                        ['label' => trans('user.regiter_date'), 'value' => $appUser->created_at->format('Y-m-d')],
                        ];
                        @endphp

                        @foreach ($personalInfo as $info)
                        <div class="info-item">
                            <span class="info-label">{{ $info['label'] }}:</span>
                            <span class="info-value">{{ $info['value'] }}</span>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title">{{ trans('user.verification_status') }}</h3>
                    <div class="vehicle-card grid-layout">
                        @php
                        $verifications = [
                        ['label' => trans('user.email_verify'), 'status' => $appUser->email_verify, 'key' =>
                        'email_verify'],
                        ['label' => trans('user.mobile_verification'), 'status' => $appUser->phone_verify, 'key' =>
                        'phone_verify'],
                        ['label' => trans('user.document_verification'), 'status' => $appUser->document_verify, 'key' =>
                        'verified'],
                        ['label' => trans('user.is_vendor_active'), 'status' => $appUser->status != 0, 'key' =>
                        'is_vendor_active'],
                        ];
                        @endphp
                        @foreach ($verifications as $verification)
                        <div class="verification-item">
                            <div class="verification-label">{{ $verification['label'] }}</div>
                            <div class="{{ $verification['status'] ? 'verified-badge' : 'unverified-badge' }}">
                                <i
                                    class="glyphicon {{ $verification['status'] ? 'glyphicon-ok' : 'glyphicon-remove' }}"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    @parent
    const confirmationOptions = {
        title: 'Are You Sure?',
        text: 'Are you sure you want to change the status?',
        confirmButtonText: 'Yes, continue',
        cancelButtonText: 'Cancel'
    };

    handleToggleUpdate(
        '.hoststatusdata',
        '/admin/update-appuser-host-status',
        'status',
        confirmationOptions
    );

</script>

@endsection