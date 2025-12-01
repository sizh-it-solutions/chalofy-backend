<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\GeneralSetting;
use App\Models\Module;
use App\Models\AppUser;
use App\Models\Modern\Item;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
class HomeController
{

    public function index()
    {
        // Fetch module data (consider caching if static)
        $module = Module::where('default_module', '1')->select('id', 'name')->first();
        $moduleId = $module->id;
        $moduleName = $module->name;

        $dashboardData = [];

        // Combine aggregate queries into a single query
       $aggregates = DB::selectOne('
    SELECT
        (SELECT COUNT(*) FROM app_users WHERE user_type = "vendor") as total_vendors,
        (SELECT COUNT(*) FROM rental_items WHERE module = ?) as total_items,
        (SELECT COUNT(*) FROM app_users WHERE user_type = "user") as total_riders,
        (SELECT COUNT(*) FROM bookings WHERE payment_status = "paid" AND module = ? AND deleted_at IS NULL) as total_paid_bookings,
        (SELECT COUNT(*) FROM bookings WHERE payment_status = "paid" AND module = ? AND DATE(created_at) = ?) as today_paid_bookings,
        (SELECT SUM(booking_finance.admin_commission)
            FROM bookings
            JOIN booking_finance ON bookings.id = booking_finance.booking_id
            WHERE bookings.payment_status = "paid"
            AND bookings.module = ?
            AND bookings.deleted_at IS NULL) as total_revenue
', [$moduleId, $moduleId, $moduleId, now()->toDateString(), $moduleId]);
if (!$aggregates) {
    $aggregates = (object)[
        'total_vendors' => 0,
        'total_items' => 0,
        'total_riders' => 0,
        'total_paid_bookings' => 0,
        'today_paid_bookings' => 0,
        'total_revenue' => 0,
    ];
}

        $dashboardData['total_vendors'] = $aggregates->total_vendors;
        $dashboardData['total_items'] = $aggregates->total_items;
        $dashboardData['total_riders'] = $aggregates->total_riders;
        $dashboardData['total_paid_bookings'] = $aggregates->total_paid_bookings;
        $dashboardData['today_paid_bookings'] = $aggregates->today_paid_bookings;
        $dashboardData['total_revenue'] = $aggregates->total_revenue;

        // Fetch latest items with constrained relationships
        $dashboardData['latest_items'] = Item::with([
            'appUser' => fn($q) => $q->select('id', 'first_name', 'last_name'),
            'place' => fn($q) => $q->select('id', 'city_name'),
            'item_Type' => fn($q) => $q->select('id', 'name')
        ])
            ->where('module', $moduleId)
            ->select('id', 'title', 'module', 'created_at', 'userid_id','item_type_id','price','place_id','status') 
            ->latest()
            ->take(5)
            ->get();

        // Fetch latest paid bookings with constrained relationships
        $dashboardData['latest_paid_bookings'] = Booking::with([
            'host' => fn($q) => $q->select('id', 'first_name', 'last_name'),
            'user' => fn($q) => $q->select('id', 'first_name', 'last_name'),
            'item' => fn($q) => $q->select('id', 'title')
        ])
            ->where('module', $moduleId)
            ->where('payment_status', 'paid')
            ->select([
                'id',
                'module',
                'payment_status',
                'created_at',
                'token',
                'check_in',
                'check_out',
                'total',
                'status',
                'itemid'
            ])
            ->latest()
            ->take(5)
            ->get();


        // Fetch latest users
        $dashboardData['latest_users'] = AppUser::where('user_type', 'user')
            ->select('id', 'first_name', 'last_name','email','phone_country','phone','created_at','status') // Adjust fields
            ->latest()
            ->take(5)
            ->get();

     
        $dashboardData['top_products_by_views'] = Item::with([
            'appUser' => fn($q) => $q->select('id', 'first_name', 'last_name'),
            'place' => fn($q) => $q->select('id', 'name')
        ])
            ->where('module', $moduleId)
            ->select('id', 'title', 'module', 'views_count') // Adjust fields
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        return view('home', compact('dashboardData', 'moduleName', 'moduleId'));
    }

    public function index_bk()
    {
        $module = Module::where('default_module', '1')->first();
        $moduleId = $module->id;
        $moduleName = $module->name;
        $settings1 = [
            'chart_title' => 'TOTAL USERS',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\AppUser',
            'group_by_field' => 'created_at',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'appUser',
        ];

        $settings1['total_number'] = 0;

        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                $query->where('user_type', 'vendor');
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }


        $settings2 = [
            'chart_title' => 'TOTAL ITEM',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Modern\Item',
            'group_by_field' => 'created_at',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'item',
            'module' => $moduleId,
        ];

        $settings2['total_number'] = 0;

        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['module'])) {
                    $query->where('module', $settings2['module']);
                }
                // if (isset($settings2['filter_days'])) {
                //     return $query->where(
                //         $settings2['filter_field'],
                //         '>=',
                //         now()->subDays($settings2['filter_days'])->format('Y-m-d')
                //     );
                // }

                // Removed all logic related to 'filter_period'
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }


        $settings3 = [
            'chart_title' => 'TOTAL PAID BOOKING',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Booking',
            'group_by_field' => 'itemid',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'booking',
            'module' => $moduleId,
        ];

        $settings3['total_number'] = 0;

        if (class_exists($settings3['model'])) {
            // Modify the query to filter only paid bookings
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                // Filter by module if provided
                if (isset($settings3['module'])) {
                    $query->where('module', $settings3['module']);
                }

                // Filter by 'payment_status' to ensure we only count paid bookings
                $query->where('payment_status', 'paid');

                // Handle date filters based on 'filter_days'
                // if (isset($settings3['filter_days'])) {
                //     return $query->where(
                //         $settings3['filter_field'],
                //         '>=',
                //         now()->subDays($settings3['filter_days'])->format('Y-m-d')
                //     );
                // }

                // Remove 'filter_period' handling
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }


        $settings4 = [
            'chart_title' => 'TOTAL RIDERS',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\AppUser', // changed from Item to AppUser
            'group_by_field' => 'created_at',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'appUser',
        ];

        $settings4['total_number'] = 0;

        if (class_exists($settings4['model'])) {
            $settings4['total_number'] = $settings4['model']::when(isset($settings4['filter_field']), function ($query) use ($settings4) {
                $query->where('user_type', 'user'); // filtering riders only

                return $query;
            })
                ->{$settings4['aggregate_function'] ?? 'count'}($settings4['aggregate_field'] ?? '*');
        }




        $settings5 = [
            'chart_title' => 'TOTAL REVENUE',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Booking',
            'group_by_field' => 'check_in',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'admin_commission',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'booking',
            'module' => $moduleId,
        ];

        $settings5['total_number'] = 0;

        if (class_exists($settings5['model'])) {
            $query = $settings5['model']::when(isset($settings5['filter_field']), function ($query) use ($settings5) {
                if (isset($settings5['module'])) {
                    $query->where('module', $settings5['module']);
                }
                $query->whereIn('status', ['Confirmed']);
            })
                ->where('payment_status', 'paid')
                ->whereNull('deleted_at');

            $settings5['total_number'] = $query
                ->join('booking_finance', 'bookings.id', '=', 'booking_finance.booking_id')
                ->sum('booking_finance.admin_commission');
        }


        $settings6 = [
            'chart_title' => 'TODAY BOOKING',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Booking',
            'group_by_field' => 'check_in',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'today',
            'group_by_field_format' => 'Y-m-d',
            'column_class' => 'col-md-4',
            'entries_number' => '5',
            'translation_key' => 'booking',
            'module' => $moduleId,

        ];

        $settings6['total_number'] = 0;
        if (class_exists($settings6['model'])) {
            $settings6['total_number'] = $settings6['model']::when(isset($settings6['filter_field']), function ($query) use ($settings6) {
                if (isset($settings6['module'])) {
                    $query->where('module', $settings6['module']);
                }
                if (isset($settings6['filter_days'])) {
                    return $query->where(
                        $settings6['filter_field'],
                        '>=',
                        now()->subDays($settings6['filter_days'])->format('Y-m-d')
                    );
                } elseif (isset($settings6['filter_period'])) {
                    switch ($settings6['filter_period']) {
                        case 'week':
                            $start = Carbon::now()->startOfWeek()->format('Y-m-d');
                            break;
                        case 'month':
                            $start = Carbon::now()->startOfMonth()->format('Y-m-d');
                            break;
                        case 'year':
                            $start = Carbon::now()->startOfYear()->format('Y-m-d');
                            break;
                        case 'today': // Add a case for 'today'
                            $start = Carbon::now()->format('Y-m-d');
                            break;
                        default:
                            $start = null;
                    }
                    if (isset($start)) {
                        return $query->where($settings6['filter_field'], '>=', $start);
                    }
                }
            })
                        ->where('bookings.payment_status', 'paid')

                ->{$settings6['aggregate_function'] ?? 'count'}($settings6['aggregate_field'] ?? '*');
        }

        $settings7 = [
            'chart_title' => 'Latest Item',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Modern\Item',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'fields' => [
                'title' => 'title',
                'userid' => 'first_name',
                'item_type' => 'name',
                'price' => 'price',
                'place' => 'place',
                'status' => 'status',
            ],
            'translation_key' => 'global',
            'module' => $moduleId,
        ];



        $settings7['data'] = $settings7['model']::with(['appUser', 'place'])
            ->where('module', $moduleId)
            ->latest()
            ->take($settings7['entries_number'])
            ->get();


        if (!array_key_exists('fields', $settings7)) {
            $settings7['fields'] = [];
        }

        $settings8 = [
            'chart_title' => 'Latest Bookings',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Booking',
            'group_by_field' => 'check_in',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'fields' => [
                'token' => 'token',
                'item_title' => 'item_title',
                'check_in' => '',
                'check_out' => '',
                'total' => 'total',
                'status' => 'status',
            ],
            'translation_key' => 'global',
            'module' => $moduleId,

        ];
        $currency = GeneralSetting::where('meta_key', 'general_default_currency_symbol')->first();


        $settings8['data'] = $settings8['model']::with(['host', 'user', 'item'])
            ->where('module', $moduleId)
            ->where('payment_status', 'paid')
            ->latest()
            ->take($settings8['entries_number'])
            ->get();

        if (!array_key_exists('fields', $settings8)) {
            $settings8['fields'] = [];
        }


        // Add this array with settings for displaying latest users
        $settings9 = [
            'chart_title' => 'Latest Users',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\AppUser',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'fields' => [
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'email' => 'email',
                'created_at' => 'created_at',
                'status' => 'status',
            ],
            'translation_key' => 'global',

        ];

        // Retrieve latest users data
        $settings9['data'] = [];
        if (class_exists($settings9['model'])) {
            $settings9['data'] = $settings9['model']::where('user_type', 'user')->latest()
                ->take($settings9['entries_number'])
                ->get();
        }

        // If 'fields' key is not present in $settings9 array, initialize it as an empty array
        if (!array_key_exists('fields', $settings9)) {
            $settings9['fields'] = [];
        }


        // Add this array with settings for displaying top products based on views_count
        $settings10 = [
            'chart_title' => 'Top Products by Views Count',
            'chart_type' => 'top_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Modern\Item',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'order_by_field' => 'views_count',
            'column_class' => 'col-md-12',
            'order_by_direction' => 'desc',
            'entries_number' => '5',
            'fields' => [
                'title' => 'title',
                'userid' => 'first_name',
                'item_type' => 'name',
                'price' => 'price',
                'place' => 'place',

            ],
            'translation_key' => 'global',

        ];


        $settings10['data'] = [];
        if (class_exists($settings10['model'])) {
            $settings10['data'] = $settings10['model']::with(['appUser', 'place'])
                ->where('module', $moduleId)
                ->orderBy($settings10['order_by_field'], $settings10['order_by_direction'])
                ->take($settings10['entries_number'])
                ->get();
        }

        // If 'fields' key is not present in $settings10 array, initialize it as an empty array
        if (!array_key_exists('fields', $settings10)) {
            $settings10['fields'] = [];
        }

        $latestUsersData = $this->getLatestUsersData();
        $latestBookingsData = $this->getLatestBookingsData($moduleId);
        return view('home', compact('settings1', 'settings2', 'settings3', 'settings4', 'latestUsersData', 'latestBookingsData', 'settings5', 'settings6', 'settings7', 'settings8', 'currency', 'moduleName', 'moduleId', 'settings9', 'settings10'));
    }


    private function getLatestUsersData()
    {
        $startDate = Carbon::now()->subWeek()->startOfDay(); // Last 7 days
        $endDate = Carbon::now()->endOfDay();

        return \DB::table('app_users')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('user_type', 'user')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($record) {
                return [
                    'date' => $record->date,
                    'count' => $record->count,
                ];
            });
    }

    private function getLatestBookingsData($moduleId)
    {
        $startDate = Carbon::now()->subWeek()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        return \DB::table('bookings')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('module', $moduleId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($record) {
                return [
                    'date' => $record->date,
                    'count' => $record->count,
                ];
            });
    }
}
