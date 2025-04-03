<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('materials', 'deleted_at')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->softDeletes(); // Add soft deletes
            });
        }
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove soft deletes
        });
    }
};
