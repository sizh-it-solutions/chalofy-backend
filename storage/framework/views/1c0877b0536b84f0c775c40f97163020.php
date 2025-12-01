
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/user-profile.css')); ?>?<?php echo e(time()); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('admin.appUsers.vendor.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                                    <input type="checkbox" data-id="<?php echo e($appUser->id); ?>" class="hoststatusdata"
                                        name="hoststatusdata" <?php echo e($appUser->host_status ? 'checked' : ''); ?>>
                                    <span class="slider round"></span>
                                </label>

                                <span class="text-sm font-bold text-green-600 flex items-center gap-1">
                                    <i class="fas fa-check-circle text-success"></i>Booking Enabled
                                </span>
                            </div>
                        </div>




                        <?php if($appUser->profile_image): ?>
                        <a href="<?php echo e($appUser->profile_image->getUrl()); ?>" target="_blank">
                            <img src="<?php echo e($appUser->profile_image->getUrl('preview')); ?>" alt="Profile Image">
                        </a>
                        <?php else: ?>
                        <div class="avatar"></div>
                        <?php endif; ?>
                        <h1 class="profile-name"><?php echo e($appUser->first_name); ?> <?php echo e($appUser->last_name); ?></h1>
                        <div class="profile-username">#<?php echo e($appUser->id); ?></div>


                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title"><?php echo e(trans('user.booking_information')); ?></h3>
                    <div class="vehicle-card grid-layout">
                        <?php
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
                        ?>
                        <?php $__currentLoopData = $bookingStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $queryParams = [
                        'from' => '',
                        'to' => '',
                        'customer' => '',
                        'host' => $appUser->id,
                        'status' => $stat['status'],
                        'btn' => ''
                        ];
                        $statUrl = $baseBookingUrl . '?' . http_build_query($queryParams);
                        ?>


                        <div class="info-item">
                            <span class="info-label">
                                <a href="<?php echo e($statUrl); ?>" target="_blank" class="text-blue-600 hover:underline">
                                    <?php echo e($stat['label']); ?>:
                                </a>
                            </span>
                            <span class="info-value"><?php echo e($data[$stat['key']]); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title"><?php echo e(trans('user.today_earnings')); ?></h3>
                    <div class="vehicle-card grid-layout">
                        <?php
                        $currency = Config::get('general.general_default_currency') ?? '';
                        $earnings = [
                        ['label' => trans('user.today_earnings'), 'key' => 'today_earnings'],
                        ['label' => trans('user.admin_commission'), 'key' => 'admin_commission'],
                        ['label' => trans('user.vendor_earnings'), 'key' => 'driver_earnings'],
                        ['label' => trans('user.by_cash'), 'key' => 'cash_earnings'],
                        ['label' => trans('user.by_card_online'), 'key' => 'online_earnings'],
                        ];
                        ?>
                        <?php $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="info-item">
                            <span class="info-label"><?php echo e($earning['label']); ?>:</span>
                            <span class="info-value"><?php echo e(formatCurrency($data[$earning['key']] ?? 0)); ?>

                                <?php echo e($currency); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title"><?php echo e(trans('user.personal_information')); ?></h3>
                    <div class="vehicle-card grid-layout">
                        <?php
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
                        ?>

                        <?php $__currentLoopData = $personalInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="info-item">
                            <span class="info-label"><?php echo e($info['label']); ?>:</span>
                            <span class="info-value"><?php echo e($info['value']); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>

                <div class="section">
                    <h3 class="section-title"><?php echo e(trans('user.verification_status')); ?></h3>
                    <div class="vehicle-card grid-layout">
                        <?php
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
                        ?>
                        <?php $__currentLoopData = $verifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="verification-item">
                            <div class="verification-label"><?php echo e($verification['label']); ?></div>
                            <div class="<?php echo e($verification['status'] ? 'verified-badge' : 'unverified-badge'); ?>">
                                <i
                                    class="glyphicon <?php echo e($verification['status'] ? 'glyphicon-ok' : 'glyphicon-remove'); ?>"></i>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/vendor/profile.blade.php ENDPATH**/ ?>