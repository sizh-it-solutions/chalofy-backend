<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;
use App\Models\VendorWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DistributeVendorCommissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
{
    try {

        Booking::where('status', 'Completed')
        ->where('payment_method', '!=','offline')
            ->whereHas('bookingFinance', function ($q) {
                $q->where('vendor_commission_given', 0);
            })
            ->with('bookingFinance')
            ->chunkById(100, function ($bookings) {
                DB::transaction(function () use ($bookings) {
                    $currentDate = Carbon::now();
                    $walletInserts = [];
                    $financeUpdateIds = [];

                    foreach ($bookings as $booking) {
                        $finance = $booking->bookingFinance;

                        if (!$finance) {
                          //  Log::warning("Booking #{$booking->id} has no bookingFinance relation.");
                            continue;
                        }

                        $description = "Credited {$finance->vendor_commission} to vendor ID {$booking->host_id} for Booking #{$booking->id}";
                        // Log::info($description);

                        $walletInserts[] = [
                            'vendor_id' => $booking->host_id,
                            'amount' => $finance->vendor_commission,
                            'booking_id' => $booking->id,
                            'type' => 'credit',
                            'description' => $description,
                            'created_at' => $currentDate,
                            'updated_at' => $currentDate,
                        ];

                        $financeUpdateIds[] = $finance->id;
                    }

                    if (!empty($walletInserts)) {
                        VendorWallet::insert($walletInserts);
                     //   Log::info('Inserted into VendorWallet: ' . count($walletInserts) . ' records.');
                    } else {
                      //  Log::info('No wallet inserts in this chunk.');
                    }

                    if (!empty($financeUpdateIds)) {
                        DB::table('booking_finance')
                            ->whereIn('id', $financeUpdateIds)
                            ->update([
                                'vendor_commission_given' => 1,
                                'updated_at' => $currentDate,
                            ]);
                        // Log::info('Updated booking_finance records: ' . count($financeUpdateIds));
                    } else {
                        //Log::info('No booking_finance updates in this chunk.');
                    }
                });
            });

        // Log::info('DistributeVendorCommissionJob completed successfully.');
    } catch (\Throwable $e) {
        Log::error('DistributeVendorCommissionJob failed: ' . $e->getMessage(), [
            'exception' => $e,
        ]);
    }
}

}
