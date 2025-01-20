<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove the status column
            $table->softDeletes(); // Add soft deletes
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('status'); // Add the status column back
            $table->dropSoftDeletes(); // Remove soft deletes
        });
    }
};
