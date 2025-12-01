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
        Schema::table('booking_finance', function (Blueprint $table) {
            $table->foreign(['booking_id'], 'booking_finance_ibfk_1')->references(['id'])->on('bookings')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_finance', function (Blueprint $table) {
            $table->dropForeign('booking_finance_ibfk_1');
        });
    }
};
