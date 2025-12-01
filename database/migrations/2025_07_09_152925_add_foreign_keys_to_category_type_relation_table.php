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
        Schema::table('category_type_relation', function (Blueprint $table) {
            $table->foreign(['category_id'], 'category_type_relation_ibfk_1')->references(['id'])->on('rental_item_category')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['type_id'], 'category_type_relation_ibfk_2')->references(['id'])->on('rental_item_types')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_type_relation', function (Blueprint $table) {
            $table->dropForeign('category_type_relation_ibfk_1');
            $table->dropForeign('category_type_relation_ibfk_2');
        });
    }
};
