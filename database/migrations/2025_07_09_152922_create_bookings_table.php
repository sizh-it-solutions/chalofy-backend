<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token', 10)->nullable()->index('token');
            $table->string('itemid')->index('itemid');
            $table->string('userid')->index('userid');
            $table->bigInteger('host_id')->index('host_id');
            $table->dateTime('check_in')->index('check_in');
            $table->dateTime('check_out')->nullable()->index('check_out');
            $table->string('start_time', 10)->nullable();
            $table->string('end_time', 10)->nullable();
            $table->enum('status', ['Pending', 'Cancelled', 'Confirmed', 'Declined', 'Expired', 'Refunded', 'Completed']);
            $table->decimal('total', 15)->nullable()->default(0);
            $table->string('currency_code', 10)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction')->nullable();
            $table->decimal('amount_to_pay', 15)->nullable()->default(0);
            $table->enum('payment_status', ['notpaid', 'paid', 'offline'])->nullable()->default('notpaid');
            $table->text('item_data')->nullable();
            $table->string('cancellation_reasion')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->tinyInteger('module')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
