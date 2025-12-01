<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">

            
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo e($dashboardData['total_vendors'] ?? 0); ?></h3>
                            <p class="text-uppercase"><?php echo e(__('dashboard.total_vendors')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?php echo e(route("admin.app-vendors.index", ['user_type' => 'vendor'])); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo e($dashboardData['total_items'] ?? 0); ?></h3>
                            <p class="text-uppercase"><?php echo e(__('dashboard.total_vehicles')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <a href="<?php echo e(route("admin.vehicles.index")); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3><?php echo e($dashboardData['total_paid_bookings'] ?? 0); ?></h3>
                             <p class="text-uppercase"><?php echo e(__('dashboard.total_bookings')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-calendar-outline"></i>
                        </div>
                        <a href="<?php echo e(route("admin.bookings.index")); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo e($dashboardData['total_riders'] ?? 0); ?></h3>
                             <p class="text-uppercase"><?php echo e(__('dashboard.total_users')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="<?php echo e(route('admin.app-users.index')); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo e(formatCurrency($dashboardData['total_revenue'] ?? 0)); ?> <?php echo e(Config::get('general.general_default_currency')); ?></h3>
                            <p class="text-uppercase"><?php echo e(__('dashboard.total_revenue')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>
                        <a href="<?php echo e(route('admin.finance')); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3><?php echo e($dashboardData['today_paid_bookings'] ?? 0); ?></h3>
                            <p class="text-uppercase"><?php echo e(__('dashboard.today_bookings')); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-calendar"></i>
                        </div> <?php
                            $currentDate = date('Y-m-d');
                            ?>
                        <a href="<?php echo e(route("admin.bookings.index", ['from' => $currentDate, 'to' => $currentDate])); ?>" class="small-box-footer"><?php echo e(__('global.moreInfo')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    <?php echo e(__('dashboard.latest_vehicles')); ?>

                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo e(__('global.title')); ?></th>
                                <th><?php echo e(__('global.host')); ?></th>
                                <th><?php echo e(__('global.vehicle_type')); ?></th>
                                <th><?php echo e(__('global.price')); ?></th>
                                <th><?php echo e(__('global.location')); ?></th>
                                <th><?php echo e(__('global.status')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dashboardData['latest_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                           
                                <tr>
                                    <td><a href="<?php echo e(route('admin.vehicles.base', $item->id)); ?>"><?php echo e($item->title); ?></a></td>
                                    <td><a href="<?php echo e(route('admin.vendor.profile', $item->appUser->id ?? '')); ?>"><?php echo e($item->appUser->first_name ?? ''); ?></a></td>  
                                
                                    

                                  
                                    <td><?php echo e($item->item_Type->name ?? ''); ?></td>
                                    <td><?php echo e(formatCurrency($item->price ?? 0)); ?> <?php echo e(Config::get('general.general_default_currency')); ?></td>
                                    <td><?php echo e($item->place->city_name ?? ''); ?></td>
                                    <td>
                                        <?php if($item->status == '1'): ?>
                                            <span class="label label-success"><?php echo e(__('global.active')); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo e(__('global.inactive')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6"><?php echo e(__('global.no_data_available')); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    <?php echo e(__('dashboard.latest_bookings')); ?>

                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo e(__('global.id')); ?></th>
                                <th><?php echo e(__('global.vehicle')); ?></th>
                                <th><?php echo e(__('global.start_time')); ?></th>
                                <th><?php echo e(__('global.end_time')); ?></th>
                                <th><?php echo e(__('global.total')); ?></th>
                                <th><?php echo e(__('global.status')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dashboardData['latest_paid_bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                         
                                <tr>
                                    <td> <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>"><?php echo e($booking->token); ?></a></td>
                                  <td><?php echo optional($booking->item)->id ? '<a href="'.route('admin.vehicles.base', $booking->item->id).'">'.$booking->item->title.'</a>' : ($booking->item->title ?? '—'); ?></td>
                                    <td><?php echo e($booking->check_in); ?></td>
                                    <td><?php echo e($booking->check_out); ?></td>
                                    <td><?php echo e(formatCurrency($booking->total ?? 0)); ?> <?php echo e(Config::get('general.general_default_currency')); ?></td>
                                    <td>
                                        <?php if($booking->status == 'Confirmed'): ?>
                                            <span class="label label-success"><?php echo e($booking->status); ?></span>
                                        <?php elseif($booking->status == 'Cancelled'): ?>
                                            <span class="label label-warning"><?php echo e($booking->status); ?></span>
                                        <?php else: ?>
                                            <span class="label label-info"><?php echo e($booking->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6"><?php echo e(__('global.no_data_available')); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    <?php echo e(__('dashboard.latest_customers')); ?>

                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo e(__('global.user_name')); ?></th>
                                <th><?php echo e(__('global.email')); ?></th>
                                <th><?php echo e(__('global.phone')); ?></th>
                                   <th><?php echo e(__('global.created_at')); ?></th>
                                <th><?php echo e(__('global.status')); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dashboardData['latest_users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td> <a href="<?php echo e(route('admin.customer.profile', $user->id ?? '#')); ?>"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></a></td></td>
                                    <td>   
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_contact_access')): ?>
                                          
                                            <?php echo e($user->email); ?>

                                        <?php else: ?>
                                            
                                            <?php echo e(maskEmail($user->email)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_contact_access')): ?>
                                          
                                             <?php echo e($user->phone_country ?? '-'); ?> <?php echo e($user->phone ?? '-'); ?>

                                        <?php else: ?>
                                            
                                             <?php echo e($user->phone_country ?? '-'); ?> <?php echo e(maskPhone($user->phone)); ?>

                                        <?php endif; ?>
                                       </td><td> <?php echo e($user->created_at); ?></td>
                                    <td>
                                        <?php if($user->status == '1'): ?>
                                            <span class="label label-success"><?php echo e(__('global.verified')); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo e(__('global.waiting')); ?></span>
                                        <?php endif; ?>
                                    </td>  
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5"><?php echo e(__('global.no_data_available')); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/home.blade.php ENDPATH**/ ?>