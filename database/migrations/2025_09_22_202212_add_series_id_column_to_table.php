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
            $table->unsignedBigInteger('series_id')->nullable();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scp_measurements', function (Blueprint $table) {
            $table->dropColumn('series_id');
            $table->dropColumn('deleted_at');
        });
    }
};
