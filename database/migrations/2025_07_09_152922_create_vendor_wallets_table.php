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
        Schema::create('vendor_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->index('vendor_id');
            $table->unsignedBigInteger('booking_id')->nullable()->default(0)->index('booking_id');
            $table->unsignedBigInteger('payout_id')->nullable()->default(0)->index('payout_id');
            $table->decimal('amount', 15);
            $table->enum('type', ['credit', 'debit', 'refund']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_wallets');
    }
};
