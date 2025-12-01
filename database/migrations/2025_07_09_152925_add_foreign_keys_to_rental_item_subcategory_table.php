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
        Schema::table('rental_item_subcategory', function (Blueprint $table) {
            $table->foreign(['make_id'], 'rental_item_subcategory_ibfk_1')->references(['id'])->on('rental_item_category')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_item_subcategory', function (Blueprint $table) {
            $table->dropForeign('rental_item_subcategory_ibfk_1');
        });
    }
};
