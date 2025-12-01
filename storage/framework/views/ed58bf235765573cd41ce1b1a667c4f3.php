
<?php $__env->startSection('content'); ?>
    <div class="content">

        <div class="row">
            <!-- Order Details Section -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading d-flex justify-content-between align-items-center">
                        <span><?php echo e(trans('booking.booking_details')); ?></span>
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> <?php echo e(trans('booking.back_to_bookings')); ?>

                        </a>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped">

                            <tr>
                                <th class="icon-header">
                                    <?php echo e(trans('booking.reservation_code')); ?>

                                </th>
                                <td>
                                    <span class="badge badge-pill badge-primary live-badge">
                                        <i class="fas fa-database table-icon"></i>
                                        <?php echo e($bookingData->token); ?>

                                    </span>

                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    <?php echo e(trans('booking.booking_date')); ?>

                                </th>
                                <td>
                                    <span class="badge badge-pill badge-info">
                                        <i class="far fa-clock table-icon"></i>
                                        <?php echo e(\Carbon\Carbon::parse($bookingData->created_at)->format('h:i A, Y-m-d')); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    <?php echo e(trans('booking.vehicle')); ?>

                                </th>
                                <td class="data-cell">
                                    <span class="badge badge-pill badge-primary live-badge">
                                        <i class="fas fa-car-side table-icon"></i>
                                        <?php echo e($bookingData->item->title ?? '-'); ?>

                                    </span>

                                </td>

                            </tr>

                            <tr>
                                <th class="icon-header">
                                    <?php echo e(trans('booking.start')); ?>

                                </th>
                                <td>

                                    <?php echo e($bookingData->check_in ?? '-'); ?>

                                </td>
                            </tr>
                            <tr>
                                <th class="icon-header">
                                    <?php echo e(trans('booking.end')); ?>

                                </th>
                                <td>

                                    <?php echo e($bookingData->check_out ?? '-'); ?>

                                </td>
                            </tr>


                            <tr>
                                <th class="icon-header">
                                    <i class="fas fa-traffic-light table-icon animate-bounce"></i>
                                    <?php echo e(trans('booking.booking_status')); ?>

                                </th>
                                <td>
                                    <strong>
                                        <?php if($bookingData->status === 'Ongoing'): ?>
                                            <span class="badge badge-pill label-secondary live-badge">
                                                <span class="live-dot"></span> <?php echo e(trans('booking.booking_live')); ?>

                                            </span>
                                        <?php elseif($bookingData->status === 'Cancelled'): ?>
                                            <span class="badge badge-pill badge-danger">
                                                <?php echo e(trans('booking.booking_cancelled')); ?></span>
                                        <?php elseif($bookingData->status === 'Accepted'): ?>
                                            <span class="badge badge-pill badge-success">
                                                <?php echo e(trans('booking.booking_accepted')); ?> </span>
                                        <?php elseif($bookingData->status === 'Approved'): ?>
                                            <span
                                                class="badge badge-pill badge-success"><?php echo e(trans('booking.booking_approved')); ?></span>
                                        <?php elseif($bookingData->status === 'Rejected'): ?>
                                            <span
                                                class="badge badge-pill badge-warning"><?php echo e(trans('booking.booking_rejected')); ?></span>
                                        <?php elseif($bookingData->status === 'Completed'): ?>
                                            <span
                                                class="badge badge-pill badge-info"><?php echo e(trans('booking.booking_completed')); ?></span>
                                        <?php elseif($bookingData->status === 'Refunded'): ?>
                                            <span
                                                class="badge badge-pill badge-primary"><?php echo e(trans('booking.booking_refunded')); ?></span>
                                        <?php elseif($bookingData->status === 'Confirmed'): ?>
                                            <span
                                                class="badge badge-pill badge-success"><?php echo e(trans('booking.booking_confirmed')); ?></span>
                                        <?php else: ?>
                                            <?php echo e($bookingData->status); ?>

                                        <?php endif; ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php if($bookingData->status === 'Cancelled' || $bookingData->status === 'Declined'): ?>
                                <tr>
                                    <th class="icon-header">
                                        <i class="fas fa-exclamation-circle table-icon"></i>
                                        <?php echo e(trans('booking.cancellation_reasion')); ?>

                                    </th>
                                    <td><?php echo e($bookingData->cancellation_reasion); ?></td>
                                </tr>
                            <?php endif; ?>

                        </table>


                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e(trans('booking.payments_details')); ?>

                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.payment_method')); ?>

                                </th>
                                <td>
                                    <?php
                                        $paymentMethod = strtolower($bookingData->payment_method) ?? '';
                                        $badgeClass = match ($paymentMethod) {
                                            'cash' => 'badge badge-pill label-secondary',
                                            'card', 'credit card', 'debit card' => 'badge badge-pill label-primary',
                                            'paypal' => 'badge badge-pill badge-info',
                                            'stripe' => 'badge badge-pill label-warning',
                                            'wallet' => 'badge badge-pill label-success',
                                            default => 'badge badge-pill label-light',
                                        };
                                    ?>
                                    <span class="<?php echo e($badgeClass); ?> badge-custom">
                                        <i class="fas fa-credit-card table-icon"></i>
                                        <?php echo e(ucfirst($paymentMethod)); ?>

                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.payment_status')); ?>

                                </th>
                                <td>
                                    <?php if($bookingData->payment_status === 'paid'): ?>
                                        <span class="badge badge-pill label-success badge-custom">
                                            <i class="fas fa-check-circle table-icon"></i> Paid
                                        </span>
                                    <?php elseif($bookingData->payment_status === 'notpaid'): ?>
                                        <span class="badge badge-pill label-danger badge-custom">
                                            <i class="fas fa-clock table-icon"></i> Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.ride_fare')); ?>

                                </th>
                                <td><?php echo e((formatCurrency($bookingData->total) ?? '-') . ' ' . (Config::get('general.general_default_currency') ?? '')); ?></td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.admin_commission')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->admin_commission) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?>

                                </td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.security_money')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->doorstep_price) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.doot_step_prince')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->security_money) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?></td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.iva_tax')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->iva_tax) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?></td>
                            </tr>

                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.vendor_income')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->vendor_commission) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?>

                                </td>
                            </tr>  <?php if($bookingData->status === 'Cancelled' || $bookingData->status === 'Declined' ): ?>
                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.refund_amount')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->refundableAmount) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?>

                                </td>
                            </tr>
                            <tr>
                                <th class="table-heading">
                                    <?php echo e(trans('booking.deduct_amount')); ?>

                                </th>
                                <td><?php echo e(formatCurrency($bookingData->bookingFinance->deductedAmount) ?? '-'); ?>

                                    <?php echo e(Config::get('general.general_default_currency') ?? ''); ?>

                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($bookingData->transaction)): ?>
                                <tr>
                                    <th class="table-heading">
                                        <i class="fas fa-barcode table-icon"></i>
                                        <?php echo e(trans('booking.transaction_id')); ?>

                                    </th>
                                    <td>
                                        <span class="badge badge-pill badge-dark badge-custom">
                                            <?php echo e($bookingData->transaction); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e(trans('booking.user_details')); ?>

                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2" class="text-center">
                                    <?php if($bookingData->user): ?>
                                        <a target="_blank"
                                            href="<?php echo e(route('admin.customer.profile', ['id' => $bookingData->user->id])); ?>">
                                            <?php if($bookingData->user->profile_image): ?>
                                                <img src="<?php echo e($bookingData->user->profile_image->getUrl('thumb')); ?>"
                                                    class="img-circle_details">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('public/images/icon/userdefault.jpg')); ?>" alt="Default Image"
                                                    class="img-circle_details">
                                            <?php endif; ?>
                                        </a>

                                        <?php
                                            $rating = $bookingData->user->avr_guest_rate ?? null;
                                        ?>
                                        <?php if($rating): ?>
                                            <div class="host-rating mt-1">
                                                <span class="badge badge-warning">
                                                    ⭐ <?php echo e(number_format($rating, 1)); ?>/5
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="host-rating mt-1">
                                                <span class="text-muted">No rating</span>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span>--</span>
                                    <?php endif; ?>
                                </th>
                            </tr>

                            <tr>
                                <th><?php echo e(trans('booking.name')); ?></th>
                                <td><?php echo e($bookingData->user->first_name ?? ''); ?> <?php echo e($bookingData->user->last_name ?? ''); ?>

                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(trans('booking.email')); ?></th>
                                <td><?php echo e($bookingData->user->email ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(trans('booking.phone')); ?></th>
                                <td><?php echo e($bookingData->user->phone_country ?? ''); ?> <?php echo e($bookingData->user->phone ?? ''); ?>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e(trans('booking.vendor_details')); ?>

                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2" class="text-center">
                                    <?php if($bookingData->host): ?>
                                        <a target="_blank"
                                            href="<?php echo e(route('admin.vendor.profile', ['id' => $bookingData->host->id])); ?>">
                                            <?php if($bookingData->host->profile_image): ?>
                                                <img src="<?php echo e($bookingData->host->profile_image->getUrl('thumb')); ?>"
                                                    class="img-circle_details mb-2">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('public/images/icon/userdefault.jpg')); ?>" alt="Default Image"
                                                    class="img-circle_details mb-2">
                                            <?php endif; ?>
                                        </a>
                                        <?php
                                            $rating = $bookingData->host->ave_host_rate ?? null;
                                        ?>
                                        <?php if($rating): ?>
                                            <div class="host-rating mt-1">
                                                <span class="badge badge-warning">
                                                    ⭐ <?php echo e(number_format($rating, 1)); ?>/5
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="host-rating mt-1">
                                                <span class="text-muted">No rating</span>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span>--</span>
                                    <?php endif; ?>
                                </th>


                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(trans('booking.name')); ?></th>
                                <td><?php echo e($bookingData->host->first_name ?? ''); ?> <?php echo e($bookingData->user->last_name ?? ''); ?>

                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(trans('booking.email')); ?></th>
                                <td><?php echo e($bookingData->host->email ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(trans('booking.phone')); ?></th>
                                <td><?php echo e($bookingData->host->phone_country ?? ''); ?> <?php echo e($bookingData->host->phone ?? ''); ?>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/bookings/show.blade.php ENDPATH**/ ?>