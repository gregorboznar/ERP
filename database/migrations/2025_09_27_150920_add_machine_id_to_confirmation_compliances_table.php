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
        Schema::table('confirmation_compliances', function (Blueprint $table) {
            $table->foreignId('machine_id')->nullable()->constrained('machines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirmation_compliances', function (Blueprint $table) {
            $table->dropForeign(['machine_id']);
            $table->dropColumn('machine_id');
        });
    }
};
