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
        Schema::create('rental_item_subcategory', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 50);
            $table->integer('make_id')->nullable()->index('make_id');
            $table->string('description')->nullable();
            $table->tinyInteger('module')->default(1);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_item_subcategory');
    }
};
