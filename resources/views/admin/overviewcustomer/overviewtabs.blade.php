
<ul class="cus nav nav-tabs f-14" role="tablist">
    @php
        $userType = request()->input('user_type');
   
    @endphp


    @if($userType != 'user') 
    <li class="{{ request()->routeIs('admin.profile.vendor') ? 'active' : '' }}">
            <a href="{{ route('admin.profile.vendor', $booking) }}?user_type={{ $userType }}"> {{ trans('global.full_information') }}</a>
        </li>
    <li class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
            <a href="{{ route('admin.orders', $booking) }}?user_type={{ $userType }}">{{ trans('global.Orders') }}</a>
        </li>
    <li class="{{ request()->routeIs('admin.overview') ? 'active' : '' }}">
        <a href="{{ route('admin.overview', $booking) }}?user_type={{ $userType }}">{{ trans('global.finance') }}</a>
    </li>
   
        <li class="{{ request()->routeIs('admin.item') ? 'active' : '' }}">
            <a href="{{ route('admin.item', $booking) }}?user_type={{ $userType }}">{{ trans('global.vehicle') }}</a>
        </li>
  
        <li class="{{ request()->routeIs('admin.payout') ? 'active' : '' }}">
            <a href="{{ route('admin.payout', $booking) }}?user_type={{ $userType }}">{{ trans('global.Payouts') }}</a>
        </li>
    @endif

    @if($userType == 'user')
    <li class="{{ request()->routeIs('admin.profile.customer') ? 'active' : '' }}">
            <a href="{{ route('admin.profile.customer', $booking) }}?user_type={{ $userType }}"> {{ trans('global.full_information') }}</a>
        </li>
    <li class="{{ request()->routeIs('admin.wallet') ? 'active' : '' }}">
            <a href="{{ route('admin.wallet', $booking) }}?user_type={{ $userType }}">{{ trans('global.wallet') }}</a>
        </li>
     
        <li class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}">
            <a href="{{ route('admin.booking', $booking) }}?user_type={{ $userType }}">{{ trans('global.Bookings') }}</a>
        </li>
       
       
    @endif

    <li class="{{ request()->routeIs('admin.bankAccount') ? 'active' : '' }}">
            <a href="{{ route('admin.bankAccount', $booking) }}?user_type={{ $userType }}">{{ trans('global.bank') }} {{ trans('global.account') }}</a>
        </li>
</ul>
