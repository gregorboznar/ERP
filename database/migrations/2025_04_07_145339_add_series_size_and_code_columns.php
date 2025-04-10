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
        Schema::table('series_tenders', function (Blueprint $table) {
            $table->string('series_size')->nullable();
            $table->string('series_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series_tenders', function (Blueprint $table) {
            $table->dropColumn('series_size');
            $table->dropColumn('series_code');
        });
    }
};
