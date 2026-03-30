<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingExtension;
use App\Http\Controllers\Traits\UserWalletTrait;
use App\Models\Modern\ItemDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class CleanupStaleData implements ShouldQueue
{
    use Dispatchable, Queueable, UserWalletTrait;

    public function handle()
    {
         Log::info('[Scheduler] Running CleanupStaleData at '.now());
        $this->removeUnpaidBookings();
        $this->removeOldItemDates();
    }

    protected function removeUnpaidBookings(): void
    {
        
        //$cutoff = now()->subHour();
        //$cutoff = now()->subMinutes(30);
        $cutoff = now()->subMinutes(6);

        Booking::whereIn('payment_status', ['notpaid', 'failed'])
            ->where('created_at', '<=', $cutoff)
            ->chunkById(100, function ($bookings) {
                $ids = $bookings->pluck('id');

                DB::transaction(function () use ($bookings, $ids) {

                         
                        foreach ($bookings as $booking) {
                            $finance = $booking->bookingFinance; // uses the relation

                            if ($finance && $finance->wall_amt > 0) {
                                $refundAmount = $finance->wall_amt;
                                $transactionDescription = 'wallet Refund for unpaid booking #' . $booking->id;

                                $this->addWalletTransaction(
                                    $booking->userid,       
                                    $refundAmount,
                                    'credit',
                                    $transactionDescription,
                                    $booking->currency_code
                                );
                                 \Log::info("Refunded wallet amount {$refundAmount} for user {$booking->userid} for booking #{$booking->id}");
                            }
                        }


                    ItemDate::whereIn('booking_id', $ids)
                        ->update([
                            'status'     => 'Available',
                            'booking_id' => 0,
                        ]);

                    BookingExtension::whereIn('booking_id', $ids)
                        ->delete();

                    $bookings->each->forceDelete();
                });
            });
    }
  protected function removeOldItemDates(): void
    {
        $cutoff = now()->subDays(10);

        ItemDate::whereIn('status', ['Available', 'Not available'])
            ->where('date', '<', $cutoff)
            ->chunkById(500, function ($items) {
                $ids = $items->pluck('id');
                ItemDate::whereIn('id', $ids)->delete();
            });
    }
}
