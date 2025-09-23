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
        Schema::table('scp_measurements', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();

          
            $table->date('date')->nullable()->change();
            $table->time('time')->nullable()->change();
            $table->time('nest_number')->nullable()->change();
            $table->time('piece_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scp_measurements', function (Blueprint $table) {
            $table->dropColumn('product_id');

            
            $table->date('date')->nullable(false)->change();
            $table->time('time')->nullable(false)->change();
            $table->time('nest_number')->nullable()->change();
            $table->time('piece_id')->nullable(false)->change();
        });
    }
};
