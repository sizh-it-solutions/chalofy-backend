<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ route('admin.home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span> {{ trans('global.dashboard') }} </span>
                </a>
            </li>
            @can('user_management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">
                        </i>
                        <span> {{ trans('global.adminManagement') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('permission_access')
                            <li
                                class="{{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                <a href="{{ route("admin.permissions.index") }}">
                                    <i class="fa-fw fas fa-unlock-alt">

                                    </i>
                                    <span>{{ trans('global.permission_title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="{{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                <a href="{{ route("admin.roles.index") }}">
                                    <i class="fa-fw fas fa-briefcase">

                                    </i>
                                    <span>{{ trans('global.role_title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="{{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <a href="{{ route("admin.users.index") }}">
                                    <i class="fa-fw fas fa-user">

                                    </i>
                                    <span>{{ trans('global.user_title') }}</span>

                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('vehicle_setting_access')
                @php
                    $moduleWithId2 = $modules->where('id', 2)->first();
                @endphp
                @if($moduleWithId2->status)
                    <li class="treeview">
                        <a href="#">
                            <i class="fa-fw fas fa-car">

                            </i>
                            <span>{{ trans('global.vehicles') }}</span>
                            <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @can('vehicle_features_access')

                                <li
                                    class="{{ request()->is("admin/vehicle-features") || request()->is("admin/vehicle-features/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-features.index") }}">
                                        <i class="fas fa-key"></i>

                                        <span>{{trans('global.vehicle_features') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_type_access')
                                <li
                                    class="{{ request()->is("admin/vehicle-type") || request()->is("admin/vehicle-type/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-type.index") }}">
                                        <i class="fas fa-shipping-fast">

                                        </i>
                                        <span>{{trans('global.vehicle_type') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_location_access')
                                <li
                                    class="{{ request()->is("admin/vehicle-location") || request()->is("admin/vehicle-location/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-location.index") }}">
                                        <i class="fas fa-map-marker-alt">

                                        </i>
                                        <span>{{trans('global.vehicle_location') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_makes_access')
                                <li
                                    class="{{ request()->is("admin/vehicle-makes") || request()->is("admin/vehicle-makes/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-makes.index") }}">
                                        <i class="fas fa-car">

                                        </i>
                                        <span>{{trans('global.vehicle_makes') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_model_access')
                                <li
                                    class="{{ request()->is("admin/vehicle-model") || request()->is("admin/vehicle-model/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-model.index") }}">
                                        <i class="fas fa-cube">

                                        </i>
                                        <span>{{trans('global.vehicle_model') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_odometer_access')
                                <li
                                    class="{{ request()->is("admin/vehicle-odometer") || request()->is("admin/vehicle-model/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicle-odometer.index") }}">
                                        <i class="fas fa-tachometer-alt">

                                        </i>
                                        <span>{{trans('global.vehicle_odometer') }}</span>

                                    </a>
                                </li>

                            @endcan
                            <li
                                class="{{ request()->is("admin/vehicle-fuel-type") || request()->is("admin/vehicle-fuel-type/*") ? "active" : "" }}">
                                <a href="{{ route("admin.vehicle-fuel-type.index") }}">
                                    <i class="fas fa-gas-pump">

                                    </i>
                                    <span>{{trans('global.vehicle_fuel_type') }}</span>

                                </a>
                            </li>
                            @can('vehicle_create')
                                <li
                                    class="{{ request()->is("admin/vehicles/create") || request()->is("admin/vehicles/create") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicles.create") }}">
                                        <i class="fa-fw fas fa-plus">

                                        </i>
                                        <span>{{trans('global.add')}} {{trans('global.vehicle') }}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_access')
                                <li
                                    class="{{ request()->is("admin/vehicles") || request()->is("admin/vehicles/*") ? "active" : "" }}">
                                    <a href="{{ route("admin.vehicles.index") }}">
                                        <i class="fa-fw fas fa-hotel">

                                        </i>
                                        <span>{{ trans('global.vehicle') }} {{ trans('global.list')}}</span>

                                    </a>
                                </li>
                            @endcan
                            @can('vehicle_setting_generalform_access')
                                @if(false)
                                    <li
                                        class="{{ request()->is("admin/vehicle-setting/generalform") || request()->is("admin/vehicle-setting/generalform/*") ? "active" : "" }}">
                                        <a href="{{ route("admin.vehicle-setting.generalform") }}">
                                            <i class="fa-fw fas fa-cogs">

                                            </i>
                                            <span>{{ trans('global.settings') }}</span>

                                        </a>
                                    </li>
                                @endif
                            @endcan
                        </ul>
                    </li>
                @endif
            @endcan
            @can('booking_access')
                <li class="treeview {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ trans('global.bookings') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ request()->is('admin/bookings') && !request()->query('status') ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index') }}">
                                <i class="far fa-list-alt"></i>
                                <span>{{ trans('global.booking_list') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'pending' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
                                <i class="far fa-clock"></i>
                                <span>{{ trans('global.booking_pending') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'confirmed' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">
                                <i class="far fa-check-circle"></i>
                                <span>{{ trans('global.booking_confirmed') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'cancelled' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">
                                <i class="far fa-times-circle"></i>
                                <span>{{ trans('global.booking_cancelled') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'declined' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'declined']) }}">
                                <i class="far fa-thumbs-down"></i>
                                <span>{{ trans('global.booking_declined') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'completed' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">
                                <i class="far fa-check-square"></i>
                                <span>{{ trans('global.booking_completed') }}</span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->is('admin/bookings') && request()->query('status') === 'refunded' ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.index', ['status' => 'refunded']) }}">
                                <i class="far fa-money-bill-alt"></i>
                                <span>{{ trans('global.booking_refunded') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bookings.trash') ? 'active' : '' }}">
                            <a href="{{ route('admin.bookings.trash') }}">
                                <i class="far fa-trash-alt"></i>
                                <span>{{ trans('global.booking_trash') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('package_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-gift">

                        </i>
                        <span>{{ trans('global.package_title') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('all_package_access')
                            <li class="{{ request()->is("admin/all-packages/create") ? "active" : "" }}">
                                <a href="{{ route("admin.all-packages.create") }}">
                                    <i class="fa-fw fas fa-plus">

                                    </i>
                                    <span>{{trans('global.add')}} {{ trans('global.allPackage_title_singular') }}</span>

                                </a>
                            </li>

                            <li class="{{ request()->is("admin/all-packages") ? "active" : "" }}">
                                <a href="{{ route("admin.all-packages.index") }}">
                                    <i class="fa-fw fas fa-suitcase">

                                    </i>
                                    <span>{{ trans('global.allPackage_title') }} {{ trans('global.list')}}</span>

                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('coupon_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-ticket-alt">

                        </i>
                        <span>{{ trans('global.coupon_title') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('add_coupon_access')
                            <li class="{{request()->is("admin/add-coupons/create") ? "active" : "" }}">
                                <a href="{{ route("admin.add-coupons.create") }}">
                                    <i class="fa-fw fas fa-plus">

                                    </i>
                                    <span>{{trans('global.add')}} {{ trans('global.addCoupon_title') }}</span>

                                </a>
                            </li>


                            <li class="{{ request()->is("admin/add-coupons") ? "active" : "" }}">
                                <a href="{{ route("admin.add-coupons.index") }}">
                                    <i class="fa-fw fas fa-percentage">

                                    </i>
                                    <span>{{ trans('global.addCoupon_title') }} {{ trans('global.list')}}</span>

                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('contact_access')
                <li class="{{ request()->is("admin/contacts") || request()->is("admin/contacts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.contacts.index") }}">
                        <i class="fa-fw far fa-calendar-check">

                        </i>
                        <span>{{ trans('global.contactus_title') }}</span>

                    </a>
                </li>
            @endcan
            @can('transactions_reports_access')
                <li
                    class="treeview {{ request()->is("admin/payouts*") || request()->is("admin/finance*") ? "active" : "" }}">
                    <a href="#">
                        <i class="fa-fw fas fa-users"></i>
                        <span>{{ trans('global.transactions_reports') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('finance_access')
                            <li class="{{ request()->is("admin/finance") ? "active" : "" }}">
                                <a href="{{ route("admin.finance") }}">
                                    <i class="fas fa-coins"></i>
                                    <span>{{ trans('global.finance') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('payout_access')
                            <li
                                class="{{ request()->is("admin/payouts") || request()->is("admin/payouts/*") ? "active" : "" }}">
                                <a href="{{ route("admin.payouts.index") }}">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span>{{ trans('global.payout_title') }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->query('status') == 'Success' ? 'active' : '' }}">
                                <a href="{{ route('admin.payouts.index', ['status' => 'Success']) }}">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span>{{ trans('global.payout_success') }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->query('status') == 'Pending' ? 'active' : '' }}">
                                <a href="{{ route('admin.payouts.index', ['status' => 'Pending']) }}">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span>{{ trans('global.payout_pending') }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->query('status') == 'Rejected' ? 'active' : '' }}">
                                <a href="{{ route('admin.payouts.index', ['status' => 'Rejected']) }}">
                                    <i class="fa-fw fab fa-paypal"></i>
                                    <span>{{ trans('global.payout_rejected') }}</span>
                                </a>
                            </li>

                        @endcan

                    </ul>
                </li>
            @endcan


            @can('review_access')
                <li class="{{ request()->is("admin/reviews") || request()->is("admin/reviews/*") ? "active" : "" }}">
                    <a href="{{ route("admin.reviews.index") }}">
                        <i class="fa-fw fas fa-eye-dropper">

                        </i>
                        <span>{{ trans('global.review_title') }}</span>

                    </a>
                </li>
            @endcan
            @can('front_management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span>{{ trans('global.vendor') }} {{ trans('global.management') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('app_user_access')
                            <li class="{{ request()->routeIs('admin.app-vendors.create') ? 'active' : '' }}">
                                <a href="{{ route('admin.app-vendors.create') }}">
                                    <i class="fa-fw fas fa-plus"></i>
                                    <span>{{ trans('global.add') }} {{ trans('global.vendor') }}</span>
                                </a>
                            </li>

                            <li
                                class="{{ request()->routeIs('admin.app-vendors.index') && !request()->has('host_status') ? 'active' : '' }}">
                                <a href="{{ route('admin.app-vendors.index') }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.vendor') }} {{ trans('global.list') }}</span>
                                </a>
                            </li>

                            <li
                                class="{{ request()->routeIs('admin.app-vendors.index') && request()->input('host_status') == '1' ? 'active' : '' }}">
                                <a href="{{ route('admin.app-vendors.index', ['host_status' => '1']) }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.verified') }} {{ trans('global.vendor') }}</span>
                                </a>
                            </li>

                            <li
                                class="{{ request()->routeIs('admin.app-vendors.index') && request()->input('host_status') == '2' ? 'active' : '' }}">
                                <a href="{{ route('admin.app-vendors.index', ['host_status' => '2']) }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.requested') }} {{ trans('global.vendor') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('front_management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span>{{ trans('global.frontManagement_title') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('app_user_access')
                            <li
                                class="{{ request()->is('admin/app-users/create') || request()->is('admin/customer*') ? 'active' : '' }}">
                                <a href="{{ route('admin.app-users.create') }}">
                                    <i class="fa-fw fas fa-plus"></i>
                                    <span>{{ trans('global.add') }} {{ trans('global.appUser_title') }}</span>
                                </a>
                            </li>

                            <li class="{{ request()->fullUrlIs(route('admin.app-users.index')) ? 'active' : '' }}">
                                <a href="{{ route('admin.app-users.index') }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.appUser_title') }} {{ trans('global.list') }}</span>
                                </a>
                            </li>

                            <li
                                class="{{ request()->fullUrlIs(route('admin.app-users.index', ['status' => 1])) ? 'active' : '' }}">
                                <a href="{{ route('admin.app-users.index', ['status' => 1]) }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.active_users') }}</span>
                                </a>
                            </li>

                            <li
                                class="{{ request()->fullUrlIs(route('admin.app-users.index', ['status' => 0])) ? 'active' : '' }}">
                                <a href="{{ route('admin.app-users.index', ['status' => 0]) }}">
                                    <i class="fa-fw fas fa-users"></i>
                                    <span>{{ trans('global.inactive_users') }}</span>
                                </a>
                            </li>

                        @endcan
                    </ul>
                </li>
            @endcan

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                    <span>{{ trans('global.settings') }}</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('all_general_setting_access')


                        @can('general_setting_access')
                            @php
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
                            @endphp

                            <li class="{{ $isActive ? 'active' : '' }}">
                                <a href="{{ route('admin.settings') }}">
                                    <i class="fa-fw fas fa-cogs"></i>
                                    <span>{{ trans('global.generalSetting_title') }}</span>
                                </a>
                            </li>


                        @endcan

                    @endcan
                    @can('item_rule')
                        <li
                            class="{{ request()->is("admin/item-rule") || request()->is("admin/item-rule/*") ? "active" : "" }}">
                            <a href="{{ route("admin.item-rule.index") }}">
                                <i class="fas fa-gavel">

                                </i>
                                <span>{{ trans('global.item_rule') }}</span>

                            </a>
                        </li>
                    @endcan
                    @can('cancellation_policies')
                        <li
                            class="{{ request()->is("admin/cancellation-policies") || request()->is("admin/cancellation-policies/*") ? "active" : "" }}">
                            <a href="{{ route("admin.cancellation-policies.index") }}">
                                <i class='fa fa-ban'></i>
                                <span>{{ trans('global.cancellationPolicies_title') }} </span>

                            </a>
                        </li>
                    @endcan
                    @can('cancellation_access')
                        <li
                            class="{{ request()->is("admin/cancellation") || request()->is("admin/cancellation /*") ? "active" : "" }}">
                            <a href="{{ route("admin.cancellation.index") }}">
                                <i class='fa fa-times-circle'></i>
                                <span> {{ trans('global.cancellationReason_title') }} </span>

                            </a>
                        </li>
                    @endcan
                    @can('sliders_access')
                        <li class="{{ request()->is("admin/sliders") ? "active" : "" }}" style="display: none;">

                            <a href="{{ route("admin.sliders.index") }}">
                                <i class="fa-fw fas fa-images">

                                </i>
                                <span>{{ trans('global.slider_title') }}</span>

                            </a>
                        </li>
                    @endcan
                    @can('static_page_access')
                        <li
                            class="{{ request()->is("admin/static-pages") || request()->is("admin/static-pages/*") ? "active" : "" }}">
                            <a href="{{ route("admin.static-pages.index") }}">
                                <i class="fa-fw fas fa-file">

                                </i>
                                <span>{{ trans('global.staticPage_title') }}</span>

                            </a>
                        </li>
                    @endcan
                    @can('currency_access')
                        <li
                            class="{{ request()->is("admin/currency") || request()->is("admin/currency/*") ? "active" : "" }}">
                            <a href="{{ route("admin.currency") }}">
                                <i class="fa-fw fas fa-dollar">

                                </i>
                                <span>Currency</span>

                            </a>
                        </li>
                    @endcan
                    @can('email_access')
                        <li
                            class="{{ request()->is("user/email-templates") || request()->is("user/email-templates/*") ? "active" : "" }}">

                            <a href="{{ route("user.email-templates", ['id' => 1]) }}">
                                <i class="fa fa-envelope">

                                </i>
                                <span>{{ trans('global.emailTemplate_title') }} </span>

                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <!-- end -->


            @can('support_ticket')
                <li class="{{ request()->is('admin/ticket') || request()->is('admin/ticket /*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ticket.index', ['status' => 1]) }}">
                        <i class="fa fa-ticket" aria-hidden="true"></i>
                        <span>{{ trans('global.tickets_title') }} </span>

                    </a>
                </li>
            @endcan

            @can('reports_access')
                <!--  -->
                <li style="display:none"
                    class="{{ request()->is("admin/ report-page ") || request()->is("admin/report-page /*") ? "active" : "" }}">
                    <a href="{{ route("admin.report-page.index") }}">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span>Reports </span>

                    </a>
                </li>
            @endcan
            <!--  -->
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="{{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                        <a href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key">
                            </i>
                            <span> {{ trans('global.change_password') }} </span>
                        </a>
                    </li>
                @endcan


            @endif
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="fas fa-fw fa-sign-out-alt">

                    </i>
                    <span> {{ trans('global.logout') }} </span>
                </a>
            </li>
        </ul>
    </section>
</aside>