
<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/user-profile.css')); ?>?<?php echo e(time()); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php echo $__env->make('admin.appUsers.user.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="driver-profile-page">
            <div class="profile-container">
                <div class="row g-3 text-capitalize align-items-center">
                    <?php
                        $toggles = [
                            ['label' => __('user.status'), 'field' => 'status', 'value' => $appUser->status, 'class' => 'profileVerify'],
                            ['label' => __('user.email_verify'), 'field' => 'email_verify', 'value' => $appUser->email_verify, 'class' => 'emailVerify'],
                            ['label' => __('user.phone_verify'), 'field' => 'phone_verify', 'value' => $appUser->phone_verify, 'class' => 'phoneVerify']
                        ];
                    ?>

                    <?php $__currentLoopData = $toggles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toggle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 form-group">
                            <label for="<?php echo e($toggle['field']); ?>"><?php echo e($toggle['label']); ?></label>
                            <div class="custom-toggle inline-block">
                                <label class="switch">
                                    <input type="checkbox" data-id="<?php echo e($appUser->id); ?>" class="<?php echo e($toggle['class']); ?>"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($toggle['value'] == 1 ? 'checked' : ''); ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <div class="sections-container">
                    <div class="section">
                        <div class="avatar-section">

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
                                    ['label' => trans('user.confirmed_booking'), 'key' => 'confirmed_bookings', 'status' => 'confirmed'],
                                    ['label' => trans('user.cancelled_bookings'), 'key' => 'cancelled_bookings', 'status' => 'cancelled'],
                                    ['label' => trans('user.decline_bookings'), 'key' => 'declined_bookings', 'status' => 'decline'],
                                    ['label' => trans('user.completed_bookings'), 'key' => 'completed_bookings', 'status' => 'completed'],
                                    ['label' => trans('user.total_bookings'), 'key' => 'total_bookings', 'status' => null],
                                ];
                            ?>

                            <?php $__currentLoopData = $bookingStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $queryParams = [
                                        'from' => '',
                                        'to' => '',
                                        'customer' => $userId,
                                        'host' => '',
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/user/profile.blade.php ENDPATH**/ ?>