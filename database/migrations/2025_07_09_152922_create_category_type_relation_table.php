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
        Schema::create('category_type_relation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->nullable()->index('category_id');
            $table->unsignedBigInteger('type_id')->nullable()->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_type_relation');
    }
};
