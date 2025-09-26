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
            $table->string('nominal_value')->change();
            $table->string('tolerance')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurement_characteristics', function (Blueprint $table) {
            $table->decimal('nominal_value', 10, 2)->change();
            $table->decimal('tolerance', 10, 2)->change();
        });
    }
};
