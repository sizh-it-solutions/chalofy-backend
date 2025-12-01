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
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('translatable_id');
            $table->string('translatable_type');
            $table->string('locale', 10);
            $table->string('key', 100);
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index(['locale', 'key'], 'locale_key_idx');
            $table->index(['translatable_id', 'translatable_type', 'locale', 'key'], 'translations_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
