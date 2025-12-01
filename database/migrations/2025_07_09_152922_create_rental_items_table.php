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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token', 191)->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->text('full_text_search')->nullable();
            $table->double('item_rating')->nullable()->default(0);
            $table->string('mobile')->nullable();
            $table->decimal('price', 15)->nullable();
            $table->string('currency', 3)->nullable();
            $table->longText('address')->nullable();
            $table->string('state_region')->nullable();
            $table->string('city_name')->nullable();
            $table->integer('city')->nullable();
            $table->string('country', 250)->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->unsignedBigInteger('userid_id')->nullable()->index('userid_fk_8656820');
            $table->unsignedBigInteger('item_type_id')->nullable()->index('property_type_fk_8657403');
            $table->string('features_id')->nullable()->index('amenities_id');
            $table->unsignedBigInteger('place_id')->nullable()->index('place_fk_8657368');
            $table->integer('booking_policies_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('service_type', 25)->nullable();
            $table->integer('views_count')->nullable()->default(0);
            $table->integer('module')->nullable()->default(1);
            $table->longText('steps_completed');
            $table->decimal('step_progress', 5)->default(0);
            $table->tinyInteger('is_featured')->nullable()->default(0);
            $table->boolean('is_verified')->nullable()->default(false);
            $table->boolean('status')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['item_type_id', 'subcategory_id', 'category_id'], 'property_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
