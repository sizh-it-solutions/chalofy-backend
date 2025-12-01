<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="<?php echo e(request()->is('admin') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.home')); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span> <?php echo e(trans('global.dashboard')); ?> </span>
                </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">
                        </i>
                        <span> <?php echo e(trans('global.adminManagement')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                            <li
                                class="<?php echo e(request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.permissions.index")); ?>">
                                    <i class="fa-fw fas fa-unlock-alt">

                                    </i>
                                    <span><?php echo e(trans('global.permission_title')); ?></span>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                            <li class="<?php echo e(request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.roles.index")); ?>">
                                    <i class="fa-fw fas fa-briefcase">

                                    </i>
                                    <span><?php echo e(trans('global.role_title')); ?></span>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                            <li class="<?php echo e(request()->is("admin/users") || request()->is("admin/users/*") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.users.index")); ?>">
                                    <i class="fa-fw fas fa-user">

                                    </i>
                                    <span><?php echo e(trans('global.user_title')); ?></span>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_setting_access')): ?>
                <?php
                    $moduleWithId2 = $modules->where('id', 2)->first();
                ?>
                <?php if($moduleWithId2->status): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa-fw fas fa-car">

                            </i>
                            <span><?php echo e(trans('global.vehicles')); ?></span>
                            <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_features_access')): ?>

                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-features") || request()->is("admin/vehicle-features/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-features.index")); ?>">
                                        <i class="fas fa-key"></i>

                                        <span><?php echo e(trans('global.vehicle_features')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_type_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-type") || request()->is("admin/vehicle-type/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-type.index")); ?>">
                                        <i class="fas fa-shipping-fast">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle_type')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_location_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-location") || request()->is("admin/vehicle-location/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-location.index")); ?>">
                                        <i class="fas fa-map-marker-alt">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle_location')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_makes_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-makes") || request()->is("admin/vehicle-makes/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-makes.index")); ?>">
                                        <i class="fas fa-car">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle_makes')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_model_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-model") || request()->is("admin/vehicle-model/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-model.index")); ?>">
                                        <i class="fas fa-cube">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle_model')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_odometer_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicle-odometer") || request()->is("admin/vehicle-model/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicle-odometer.index")); ?>">
                                        <i class="fas fa-tachometer-alt">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle_odometer')); ?></span>

                                    </a>
                                </li>

                            <?php endif; ?>
                            <li
                                class="<?php echo e(request()->is("admin/vehicle-fuel-type") || request()->is("admin/vehicle-fuel-type/*") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.vehicle-fuel-type.index")); ?>">
                                    <i class="fas fa-gas-pump">

                                    </i>
                                    <span><?php echo e(trans('global.vehicle_fuel_type')); ?></span>

                                </a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_create')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicles/create") || request()->is("admin/vehicles/create") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicles.create")); ?>">
                                        <i class="fa-fw fas fa-plus">

                                        </i>
                                        <span><?php echo e(trans('global.add')); ?> <?php echo e(trans('global.vehicle')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_access')): ?>
                                <li
                                    class="<?php echo e(request()->is("admin/vehicles") || request()->is("admin/vehicles/*") ? "active" : ""); ?>">
                                    <a href="<?php echo e(route("admin.vehicles.index")); ?>">
                                        <i class="fa-fw fas fa-hotel">

                                        </i>
                                        <span><?php echo e(trans('global.vehicle')); ?> <?php echo e(trans('global.list')); ?></span>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vehicle_setting_generalform_access')): ?>
                                <?php if(false): ?>
                                    <li
                                        class="<?php echo e(request()->is("admin/vehicle-setting/generalform") || request()->is("admin/vehicle-setting/generalform/*") ? "active" : ""); ?>">
                                        <a href="<?php echo e(route("admin.vehicle-setting.generalform")); ?>">
                                            <i class="fa-fw fas fa-cogs">

                                            </i>
                                            <span><?php echo e(trans('global.settings')); ?></span>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_access')): ?>
                <li class="treeview <?php echo e(request()->is('admin/bookings*') ? 'active' : ''); ?>">
                    <a href="#">
                        <i class="far fa-calendar-alt"></i>
                        <span><?php echo e(trans('global.bookings')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo e(request()->is('admin/bookings') && !request()->query('status') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index')); ?>">
                                <i class="far fa-list-alt"></i>
                                <span><?php echo e(trans('global.booking_list')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'pending' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'pending'])); ?>">
                                <i class="far fa-clock"></i>
                                <span><?php echo e(trans('global.booking_pending')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'confirmed' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'confirmed'])); ?>">
                                <i class="far fa-check-circle"></i>
                                <span><?php echo e(trans('global.booking_confirmed')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'cancelled' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'cancelled'])); ?>">
                                <i class="far fa-times-circle"></i>
                                <span><?php echo e(trans('global.booking_cancelled')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'declined' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'declined'])); ?>">
                                <i class="far fa-thumbs-down"></i>
                                <span><?php echo e(trans('global.booking_declined')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'completed' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'completed'])); ?>">
                                <i class="far fa-check-square"></i>
                                <span><?php echo e(trans('global.booking_completed')); ?></span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(request()->is('admin/bookings') && request()->query('status') === 'refunded' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.index', ['status' => 'refunded'])); ?>">
                                <i class="far fa-money-bill-alt"></i>
                                <span><?php echo e(trans('global.booking_refunded')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('admin.bookings.trash') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin.bookings.trash')); ?>">
                                <i class="far fa-trash-alt"></i>
                                <span><?php echo e(trans('global.booking_trash')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('package_access')): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-gift">

                        </i>
                        <span><?php echo e(trans('global.package_title')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_package_access')): ?>
                            <li class="<?php echo e(request()->is("admin/all-packages/create") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.all-packages.create")); ?>">
                                    <i class="fa-fw fas fa-plus">

                                    </i>
                                    <span><?php echo e(trans('global.add')); ?> <?php echo e(trans('global.allPackage_title_singular')); ?></span>

                                </a>
                            </li>

                            <li class="<?php echo e(request()->is("admin/all-packages") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.all-packages.index")); ?>">
                                    <i class="fa-fw fas fa-suitcase">

                                    </i>
                                    <span><?php echo e(trans('global.allPackage_title')); ?> <?php echo e(trans('global.list')); ?></span>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_access')): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-ticket-alt">

                        </i>
                        <span><?php echo e(trans('global.coupon_title')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_coupon_access')): ?>
                            <li class="<?php echo e(request()->is("admin/add-coupons/create") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.add-coupons.create")); ?>">
                                    <i class="fa-fw fas fa-plus">

                                    </i>
                                    <span><?php echo e(trans('global.add')); ?> <?php echo e(trans('global.addCoupon_title')); ?></span>

                                </a>
                            </li>


                            <li class="<?php echo e(request()->is("admin/add-coupons") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.add-coupons.index")); ?>">
                                    <i class="fa-fw fas fa-percentage">

                                    </i>
                                    <span><?php echo e(trans('global.addCoupon_title')); ?> <?php echo e(trans('global.list')); ?></span>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contact_access')): ?>
                <li class="<?php echo e(request()->is("admin/contacts") || request()->is("admin/contacts/*") ? "active" : ""); ?>">
                    <a href="<?php echo e(route("admin.contacts.index")); ?>">
                        <i class="fa-fw far fa-calendar-check">

                        </i>
                        <span><?php echo e(trans('global.contactus_title')); ?></span>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transactions_reports_access')): ?>
                <li
                    class="treeview <?php echo e(request()->is("admin/payouts*") || request()->is("admin/finance*") ? "active" : ""); ?>">
                    <a href="#">
                        <i class="fa-fw fas fa-users"></i>
                        <span><?php echo e(trans('global.transactions_reports')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance_access')): ?>
                            <li class="<?php echo e(request()->is("admin/finance") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.finance")); ?>">
                                    <i class="fas fa-coins"></i>
                                    <span><?php echo e(trans('global.finance')); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payout_access')): ?>
                            <li
                                class="<?php echo e(request()->is("admin/payouts") || request()->is("admin/payouts/*") ? "active" : ""); ?>">
                                <a href="<?php echo e(route("admin.payouts.index")); ?>">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span><?php echo e(trans('global.payout_title')); ?></span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->query('status') == 'Success' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.payouts.index', ['status' => 'Success'])); ?>">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span><?php echo e(trans('global.payout_success')); ?></span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->query('status') == 'Pending' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.payouts.index', ['status' => 'Pending'])); ?>">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span><?php echo e(trans('global.payout_pending')); ?></span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->query('status') == 'Rejected' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.payouts.index', ['status' => 'Rejected'])); ?>">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span><?php echo e(trans('global.payout_rejected')); ?></span>
                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('review_access')): ?>
                <li class="<?php echo e(request()->is("admin/reviews") || request()->is("admin/reviews/*") ? "active" : ""); ?>">
                    <a href="<?php echo e(route("admin.reviews.index")); ?>">
                        <i class="fa-fw fas fa-eye-dropper">

                        </i>
                        <span><?php echo e(trans('global.review_title')); ?></span>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('front_management_access')): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span><?php echo e(trans('global.vendor')); ?> <?php echo e(trans('global.management')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_access')): ?>
                            <li class="<?php echo e(request()->routeIs('admin.app-vendors.create') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-vendors.create')); ?>">
                                    <i class="fa-fw fas fa-plus"></i>
                                    <span><?php echo e(trans('global.add')); ?> <?php echo e(trans('global.vendor')); ?></span>
                                </a>
                            </li>

                            <li
                                class="<?php echo e(request()->routeIs('admin.app-vendors.index') && !request()->has('host_status') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-vendors.index')); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.vendor')); ?> <?php echo e(trans('global.list')); ?></span>
                                </a>
                            </li>

                            <li
                                class="<?php echo e(request()->routeIs('admin.app-vendors.index') && request()->input('host_status') == '1' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-vendors.index', ['host_status' => '1'])); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.verified')); ?> <?php echo e(trans('global.vendor')); ?></span>
                                </a>
                            </li>

                            <li
                                class="<?php echo e(request()->routeIs('admin.app-vendors.index') && request()->input('host_status') == '2' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-vendors.index', ['host_status' => '2'])); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.requested')); ?> <?php echo e(trans('global.vendor')); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('front_management_access')): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span><?php echo e(trans('global.frontManagement_title')); ?></span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_access')): ?>
                            <li
                                class="<?php echo e(request()->is('admin/app-users/create') || request()->is('admin/customer*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-users.create')); ?>">
                                    <i class="fa-fw fas fa-plus"></i>
                                    <span><?php echo e(trans('global.add')); ?> <?php echo e(trans('global.appUser_title')); ?></span>
                                </a>
                            </li>

                            <li class="<?php echo e(request()->fullUrlIs(route('admin.app-users.index')) ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-users.index')); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.appUser_title')); ?> <?php echo e(trans('global.list')); ?></span>
                                </a>
                            </li>

                            <li
                                class="<?php echo e(request()->fullUrlIs(route('admin.app-users.index', ['status' => 1])) ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-users.index', ['status' => 1])); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.active_users')); ?></span>
                                </a>
                            </li>

                            <li
                                class="<?php echo e(request()->fullUrlIs(route('admin.app-users.index', ['status' => 0])) ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.app-users.index', ['status' => 0])); ?>">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span><?php echo e(trans('global.inactive_users')); ?></span>
                                </a>
                            </li>

                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                    <span><?php echo e(trans('global.settings')); ?></span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_general_setting_access')): ?>


                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('general_setting_access')): ?>
                            <?php
                                $settingsRoutes = [
                                    'admin.settings',
                                    'admin.sms',
                                    'admin.email',
                                    'admin.pushnotification',
                                    'admin.fees',
                                    'admin.api-informations',
                                    'admin.paypal',
                                    'admin.social-logins',
                                    'admin.twillio',
                                    'admin.stripe',
                                    'admin.payment-methods',
                                ];
                                $isActive = in_array(Route::currentRouteName(), $settingsRoutes) || request()->is('admin/general-settings/*');
                            ?>

                            <li class="<?php echo e($isActive ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('admin.settings')); ?>">
                                    <i class="fa-fw fas fa-cogs"></i>
                                    <span><?php echo e(trans('global.generalSetting_title')); ?></span>
                                </a>
                            </li>


                        <?php endif; ?>

                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_rule')): ?>
                        <li
                            class="<?php echo e(request()->is("admin/item-rule") || request()->is("admin/item-rule/*") ? "active" : ""); ?>">
                            <a href="<?php echo e(route("admin.item-rule.index")); ?>">
                                <i class="fas fa-gavel">

                                </i>
                                <span><?php echo e(trans('global.item_rule')); ?></span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_policies')): ?>
                        <li
                            class="<?php echo e(request()->is("admin/cancellation-policies") || request()->is("admin/cancellation-policies/*") ? "active" : ""); ?>">
                            <a href="<?php echo e(route("admin.cancellation-policies.index")); ?>">
                                <i class='fa fa-ban'></i>
                                <span><?php echo e(trans('global.cancellationPolicies_title')); ?> </span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_access')): ?>
                        <li
                            class="<?php echo e(request()->is("admin/cancellation") || request()->is("admin/cancellation /*") ? "active" : ""); ?>">
                            <a href="<?php echo e(route("admin.cancellation.index")); ?>">
                                <i class='fa fa-times-circle'></i>
                                <span> <?php echo e(trans('global.cancellationReason_title')); ?> </span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sliders_access')): ?>
                        <li class="<?php echo e(request()->is("admin/sliders") ? "active" : ""); ?>" style="display: none;">

                            <a href="<?php echo e(route("admin.sliders.index")); ?>">
                                <i class="fa-fw fas fa-images">

                                </i>
                                <span><?php echo e(trans('global.slider_title')); ?></span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('static_page_access')): ?>
                        <li
                            class="<?php echo e(request()->is("admin/static-pages") || request()->is("admin/static-pages/*") ? "active" : ""); ?>">
                            <a href="<?php echo e(route("admin.static-pages.index")); ?>">
                                <i class="fa-fw fas fa-file">

                                </i>
                                <span><?php echo e(trans('global.staticPage_title')); ?></span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('currency_access')): ?>
                        <li
                            class="<?php echo e(request()->is("admin/currency") || request()->is("admin/currency/*") ? "active" : ""); ?>">
                            <a href="<?php echo e(route("admin.currency")); ?>">
                                <i class="fa-fw fas fa-dollar">

                                </i>
                                <span>Currency</span>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('email_access')): ?>
                        <li
                            class="<?php echo e(request()->is("user/email-templates") || request()->is("user/email-templates/*") ? "active" : ""); ?>">

                            <a href="<?php echo e(route("user.email-templates", ['id' => 1])); ?>">
                                <i class="fa fa-envelope">

                                </i>
                                <span><?php echo e(trans('global.emailTemplate_title')); ?> </span>

                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <!-- end -->


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('support_ticket')): ?>
                <li class="<?php echo e(request()->is('admin/ticket') || request()->is('admin/ticket /*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.ticket.index', ['status' => 1])); ?>">
                        <i class="fa fa-ticket" aria-hidden="true"></i>
                        <span><?php echo e(trans('global.tickets_title')); ?> </span>

                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reports_access')): ?>
                <!--  -->
                <li style="display:none"
                    class="<?php echo e(request()->is("admin/ report-page ") || request()->is("admin/report-page /*") ? "active" : ""); ?>">
                    <a href="<?php echo e(route("admin.report-page.index")); ?>">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span>Reports </span>

                    </a>
                </li>
            <?php endif; ?>
            <!--  -->
            <?php if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile_password_edit')): ?>
                    <li class="<?php echo e(request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('profile.password.edit')); ?>">
                            <i class="fa-fw fas fa-key">
                            </i>
                            <span> <?php echo e(trans('global.change_password')); ?> </span>
                        </a>
                    </li>
                <?php endif; ?>


            <?php endif; ?>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="fas fa-fw fa-sign-out-alt">

                    </i>
                    <span> <?php echo e(trans('global.logout')); ?> </span>
                </a>
            </li>
        </ul>
    </section>
</aside><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/partials/menu.blade.php ENDPATH**/ ?>