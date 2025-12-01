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
        Schema::create('rental_item_vehicle', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('item_id')->unique('item_id');
            $table->string('year')->index('year');
            $table->string('odometer', 50);
            $table->integer('fuel_type_id')->nullable()->index('fuel_type_id');
            $table->string('transmission', 50)->nullable();
            $table->integer('number_of_seats')->nullable()->default(1);

            $table->index(['item_id'], 'item_id_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_item_vehicle');
    }
};
