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
        Schema::table('machines', function (Blueprint $table) {
            $table->date('control_period')->nullable()->change();
           
            $table->string('manufacturer')->nullable()->change();
            $table->string('inventory_number')->nullable()->change();
            $table->string('machine_type')->nullable()->change();
            $table->string('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->date('control_period')->nullable(false)->change();
            
            $table->string('manufacturer')->nullable(false)->change();
            $table->string('inventory_number')->nullable(false)->change();
            $table->string('machine_type')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
        });
    }
};
