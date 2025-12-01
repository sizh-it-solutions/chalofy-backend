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
        Schema::create('booking_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('booking_id')->index('booking_id');
            $table->boolean('is_item_delivered')->nullable()->default(false);
            $table->boolean('is_item_received')->nullable()->default(false);
            $table->boolean('is_item_returned')->nullable()->default(false);
            $table->string('pick_otp', 10)->nullable();
            $table->string('drop_otp', 10)->nullable();
            $table->text('doorStep_address')->nullable();
            $table->decimal('doorStep_price', 15)->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_extensions');
    }
};
