<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Module, AppUser, GeneralSetting,BookingFinance};
use App\Http\Controllers\Traits\{MediaUploadingTrait};
use App\Models\Modern\{Item};
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;
class FinanceController extends Controller
{
    use MediaUploadingTrait;

        public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $from = request()->input('from');
        $to = request()->input('to');
        $item = request()->input('item');
        $host = request()->input('host');
        $customer = request()->input('customer');
        $status = request()->input('status');
        $module = request()->input('module');
        $currentModule = app('currentModule');
        $base = Booking::query()->where('module', $currentModule->id)
         ->where('payment_status', 'paid');

      

        if ($from || $to) {
            $fromDate = $from ? "$from 00:00:00" : null;
            $toDate = $to ? "$to 23:59:59" : null;
            $base->when($fromDate && $toDate, fn($q) => $q->whereBetween('bookings.created_at', [$fromDate, $toDate]))
                ->when($fromDate && !$toDate, fn($q) => $q->where('bookings.created_at', '>=', $fromDate))
                ->when(!$fromDate && $toDate, fn($q) => $q->where('bookings.created_at', '<=', $toDate));
        }

        $base->when($host, fn($q) => $q->where('host_id', $host))
            ->when($customer, fn($q) => $q->where('userid', $customer))
            ->when($item, fn($q) => $q->where('itemid', $item))
            ->when($module, fn($q) => $q->where('module', $module));

        $statusAggregates = (clone $base)
            ->join('booking_finance AS bf', 'bf.booking_id', 'bookings.id')
            ->selectRaw("
        SUM(CASE WHEN bookings.status != 'trash' AND bookings.deleted_at IS NULL THEN 1 ELSE 0 END) AS live_count,
      
        SUM(CASE WHEN bookings.status != 'cancelled' AND bookings.deleted_at IS NULL THEN bookings.total ELSE 0 END) AS total_earnings,
         SUM(
        CASE
            WHEN bookings.status IN ('Cancelled','Declined')
             AND bookings.deleted_at IS NULL
            THEN bf.refundableAmount
            ELSE 0
        END
    ) AS total_refunded,
        SUM(CASE WHEN bookings.deleted_at IS NULL THEN bookings.total ELSE 0 END) AS total_sum,
        COUNT(DISTINCT CASE WHEN bookings.deleted_at IS NULL THEN bookings.userid ELSE NULL END) AS total_customers,
        SUM(CASE WHEN bookings.deleted_at IS NULL THEN bf.admin_commission ELSE 0 END) AS total_admin_commission,
         SUM(CASE WHEN bookings.deleted_at IS NULL THEN bf.security_money ELSE 0 END) AS total_security_money,
        SUM(CASE WHEN bookings.deleted_at IS NULL THEN bf.vendor_commission ELSE 0 END) AS total_vendor_commission
    ")
            ->first();

        $statusCounts = [
            'live' => $statusAggregates->live_count
        ];
        $statusAggregates->total_refunded;
        $totalEarnings = $statusAggregates->total_earnings;
        $totalRefunded = $statusAggregates->total_refunded;
        $totalSum = $statusAggregates->total_sum;
        $total_security_money = $statusAggregates->total_security_money;
        $totalBookings = $statusAggregates->live_count;
        $totalCustomers = $statusAggregates->total_customers;
        $totalAdminCommission = $statusAggregates->total_admin_commission;
        $totalVendorCommission = $statusAggregates->total_vendor_commission;
          if (\Route::currentRouteName() === 'admin.bookings.trash') {
            $base->onlyTrashed();
            $status = null; 
        } 
        $bookings = $base
            ->when($status, fn($q) => $q->where('status', $status))
            ->with([
                'host:id,first_name,last_name,user_type',
                'user:id,first_name,last_name,user_type',
                'item:id,title',
                'bookingFinance'
            ])
            ->orderByDesc('id')
            ->paginate(50)
            ->appends(array_filter([
                'status' => $status,
                'to' => $to,
                'from' => $from,
                'host' => $host,
                'customer' => $customer,
                'item' => $item,
            ]));

        $hostId = request()->input('host');
        $customerId = request()->input('customer');
        $itemId = request()->input('item');

        $users = AppUser::whereIn('id', array_filter([$hostId, $customerId]))->get()->keyBy('id');
        $item = $itemId ? Item::find($itemId) : null;

        $host = $users->get($hostId);
        $vendorName = $host ? $host->first_name ." ". $host->last_name: 'All';
        $vendorId = $host ? $host->id : '';

        $customer = $users->get($customerId);
        $searchCustomer = $customer ? $customer->first_name : 'All';
        $searchCustomerId = $customer ? $customer->id : '';

        $searchfieldItem = $item ? $item->title : 'All';
        $searchfieldItemId = $item ? $item->id : '';
        return view('admin.finance.index', compact('bookings', 'totalCustomers', 'totalRefunded', 'totalEarnings', 'totalBookings', 'searchCustomer', 'searchCustomerId', 'totalSum', 'statusCounts', 'searchfieldItem', 'searchfieldItemId', 'vendorName', 'vendorId','totalAdminCommission','totalVendorCommission','total_security_money'));
    }
    
public function ticketDeleteAll(Request $request) {
    $ids = $request->input('ids');
   
    if (!empty($ids)) {
        try {
            Booking::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Items deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

}
}