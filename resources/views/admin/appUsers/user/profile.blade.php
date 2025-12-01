@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}?{{ time() }}">
@endsection
@section('content')
    <div class="content container-fluid">
        @include('admin.appUsers.user.menu')
        <div class="driver-profile-page">
            <div class="profile-container">
                <div class="row g-3 text-capitalize align-items-center">
                    @php
                        $toggles = [
                            ['label' => __('user.status'), 'field' => 'status', 'value' => $appUser->status, 'class' => 'profileVerify'],
                            ['label' => __('user.email_verify'), 'field' => 'email_verify', 'value' => $appUser->email_verify, 'class' => 'emailVerify'],
                            ['label' => __('user.phone_verify'), 'field' => 'phone_verify', 'value' => $appUser->phone_verify, 'class' => 'phoneVerify']
                        ];
                    @endphp

                    @foreach($toggles as $toggle)
                        <div class="col-md-4 form-group">
                            <label for="{{ $toggle['field'] }}">{{ $toggle['label'] }}</label>
                            <div class="custom-toggle inline-block">
                                <label class="switch">
                                    <input type="checkbox" data-id="{{ $appUser->id }}" class="{{ $toggle['class'] }}"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" {{ $toggle['value'] == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="sections-container">
                    <div class="section">
                        <div class="avatar-section">

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
                                    ['label' => trans('user.confirmed_booking'), 'key' => 'confirmed_bookings', 'status' => 'confirmed'],
                                    ['label' => trans('user.cancelled_bookings'), 'key' => 'cancelled_bookings', 'status' => 'cancelled'],
                                    ['label' => trans('user.decline_bookings'), 'key' => 'declined_bookings', 'status' => 'decline'],
                                    ['label' => trans('user.completed_bookings'), 'key' => 'completed_bookings', 'status' => 'completed'],
                                    ['label' => trans('user.total_bookings'), 'key' => 'total_bookings', 'status' => null],
                                ];
                            @endphp

                            @foreach ($bookingStats as $stat)
                                @php
                                    $queryParams = [
                                        'from' => '',
                                        'to' => '',
                                        'customer' => $userId,
                                        'host' => '',
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
            '.profileVerify',
            '/admin/update-appuser-status',
            'status',
            confirmationOptions
        );

        handleToggleUpdate(
            '.emailVerify',
            '/admin/update-appuser-emailverify',
            'email_verify',
            confirmationOptions
        );

        handleToggleUpdate(
            '.documentVerify',
            '/admin/update-appuser-host-status',
            'document_verify',
            confirmationOptions
        );

        handleToggleUpdate(
            '.phoneVerify',
            '/admin/update-appuser-phoneverify',
            'phone_verify',
            confirmationOptions
        );

    </script>

@endsection