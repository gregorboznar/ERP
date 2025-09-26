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
        Schema::table('measurement_characteristics', function (Blueprint $table) {
            $table->string('nominal_value')->nullable()->change();
            $table->string('tolerance')->nullable()->change();
            $table->string('name')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurement_characteristics', function (Blueprint $table) {
            $table->string('nominal_value')->nullable(false)->change();
            $table->string('tolerance')->nullable(false)->change();
            $table->string('name')->nullable(false)->change();
        });
    }
};
