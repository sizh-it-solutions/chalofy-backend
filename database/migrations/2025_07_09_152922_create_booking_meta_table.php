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
        Schema::create('booking_meta', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->timestamps();

            $table->unique(['booking_id', 'meta_key'], 'booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_meta');
    }
};
