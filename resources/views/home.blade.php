@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">

            {{-- KPI Boxes --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $dashboardData['total_vendors'] ?? 0 }}</h3>
                            <p class="text-uppercase">{{ __('dashboard.total_vendors') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route("admin.app-vendors.index", ['user_type' => 'vendor']) }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $dashboardData['total_items'] ?? 0 }}</h3>
                            <p class="text-uppercase">{{ __('dashboard.total_vehicles') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <a href="{{ route("admin.vehicles.index") }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3>{{ $dashboardData['total_paid_bookings'] ?? 0 }}</h3>
                             <p class="text-uppercase">{{ __('dashboard.total_bookings') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-calendar-outline"></i>
                        </div>
                        <a href="{{  route("admin.bookings.index") }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $dashboardData['total_riders'] ?? 0 }}</h3>
                             <p class="text-uppercase">{{ __('dashboard.total_users') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ route('admin.app-users.index') }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ formatCurrency($dashboardData['total_revenue'] ?? 0) }} {{ Config::get('general.general_default_currency') }}</h3>
                            <p class="text-uppercase">{{ __('dashboard.total_revenue') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>
                        <a href="{{ route('admin.finance') }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>{{ $dashboardData['today_paid_bookings'] ?? 0 }}</h3>
                            <p class="text-uppercase">{{ __('dashboard.today_bookings') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-calendar"></i>
                        </div> @php
                            $currentDate = date('Y-m-d');
                            @endphp
                        <a href="{{ route("admin.bookings.index", ['from' => $currentDate, 'to' => $currentDate]) }}" class="small-box-footer">{{ __('global.moreInfo') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            {{-- Latest Vehicles Table --}}
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    {{ __('dashboard.latest_vehicles') }}
                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('global.title') }}</th>
                                <th>{{ __('global.host') }}</th>
                                <th>{{ __('global.vehicle_type') }}</th>
                                <th>{{ __('global.price') }}</th>
                                <th>{{ __('global.location') }}</th>
                                <th>{{ __('global.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['latest_items'] as $item)
                           
                                <tr>
                                    <td><a href="{{ route('admin.vehicles.base', $item->id) }}">{{ $item->title }}</a></td>
                                    <td><a href="{{ route('admin.vendor.profile', $item->appUser->id ?? '') }}">{{ $item->appUser->first_name ?? '' }}</a></td>  
                                
                                    

                                  
                                    <td>{{ $item->item_Type->name ?? '' }}</td>
                                    <td>{{ formatCurrency($item->price ?? 0) }} {{ Config::get('general.general_default_currency') }}</td>
                                    <td>{{ $item->place->city_name ?? '' }}</td>
                                    <td>
                                        @if($item->status == '1')
                                            <span class="label label-success">{{ __('global.active') }}</span>
                                        @else
                                            <span class="label label-danger">{{ __('global.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">{{ __('global.no_data_available') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Latest Bookings Table --}}
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    {{ __('dashboard.latest_bookings') }}
                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('global.id') }}</th>
                                <th>{{ __('global.vehicle') }}</th>
                                <th>{{ __('global.start_time') }}</th>
                                <th>{{ __('global.end_time') }}</th>
                                <th>{{ __('global.total') }}</th>
                                <th>{{ __('global.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['latest_paid_bookings'] as $booking)
                
                         
                                <tr>
                                    <td> <a href="{{ route('admin.bookings.show', $booking->id) }}">{{ $booking->token }}</a></td>
                                  <td>{!! optional($booking->item)->id ? '<a href="'.route('admin.vehicles.base', $booking->item->id).'">'.$booking->item->title.'</a>' : ($booking->item->title ?? '—') !!}</td>
                                    <td>{{ $booking->check_in }}</td>
                                    <td>{{ $booking->check_out }}</td>
                                    <td>{{ formatCurrency($booking->total ?? 0) }} {{ Config::get('general.general_default_currency') }}</td>
                                    <td>
                                        @if($booking->status == 'Confirmed')
                                            <span class="label label-success">{{ $booking->status }}</span>
                                        @elseif($booking->status == 'Cancelled')
                                            <span class="label label-warning">{{ $booking->status }}</span>
                                        @else
                                            <span class="label label-info">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">{{ __('global.no_data_available') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Latest Customers Table --}}
            <div class="panel panel-default homePagePanel">
                <div class="panel-heading">
                    {{ __('dashboard.latest_customers') }}
                </div>
                <div class="panel-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('global.user_name') }}</th>
                                <th>{{ __('global.email') }}</th>
                                <th>{{ __('global.phone') }}</th>
                                   <th>{{ __('global.created_at') }}</th>
                                <th>{{ __('global.status') }}</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['latest_users'] as $user)
                                <tr>
                                    <td> <a href="{{ route('admin.customer.profile', $user->id ?? '#') }}">{{ $user->first_name }} {{ $user->last_name }}</a></td></td>
                                    <td>   
                                        @can('app_user_contact_access')
                                          
                                            {{$user->email }}
                                        @else
                                            
                                            {{ maskEmail($user->email) }}
                                        @endcan
                                    </td>
                                    <td>
                                    @can('app_user_contact_access')
                                          
                                             {{ $user->phone_country ?? '-' }} {{ $user->phone ?? '-' }}
                                        @else
                                            
                                             {{ $user->phone_country ?? '-' }} {{ maskPhone($user->phone) }}
                                        @endcan
                                       </td><td> {{ $user->created_at }}</td>
                                    <td>
                                        @if($user->status == '1')
                                            <span class="label label-success">{{ __('global.verified') }}</span>
                                        @else
                                            <span class="label label-danger">{{ __('global.waiting') }}</span>
                                        @endif
                                    </td>  
                                </tr>
                            @empty
                                <tr><td colspan="5">{{ __('global.no_data_available') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
