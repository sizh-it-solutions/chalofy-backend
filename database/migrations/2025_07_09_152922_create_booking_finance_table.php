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
        Schema::create('booking_finance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('booking_id')->index('booking_id');
            $table->integer('total_day');
            $table->decimal('per_day', 15);
            $table->decimal('base_price', 15);
            $table->decimal('doorstep_price', 15)->nullable()->default(0);
            $table->decimal('security_money', 15)->nullable()->default(0);
            $table->decimal('iva_tax', 15)->nullable()->default(0);
            $table->string('coupon_code', 100)->nullable();
            $table->double('coupon_discount')->default(0);
            $table->double('discount_price')->default(0);
            $table->decimal('admin_commission', 24)->default(0);
            $table->decimal('vendor_commission', 24)->default(0);
            $table->tinyInteger('vendor_commission_given')->default(0);
            $table->decimal('cancelled_charge', 15)->default(0);
            $table->decimal('wall_amt', 15)->nullable()->default(0);
            $table->double('deductedAmount')->default(0);
            $table->double('refundableAmount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_finance');
    }
};
