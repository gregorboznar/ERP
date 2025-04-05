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
        Schema::table('packagings', function (Blueprint $table) {
            $table->dropColumn('waste');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packagings', function (Blueprint $table) {
            $table->decimal('waste', 10, 2)->nullable();
        });
    }
};
