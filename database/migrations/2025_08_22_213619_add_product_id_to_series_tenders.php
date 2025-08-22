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
            $table->foreignId('product_id')->nullable()->constrained('products')->after('id');

            if (!Schema::hasColumn('series_tenders', 'article')) {
                $table->string('article')->nullable()->after('product_id');
            } else {
                $table->string('article')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series_tenders', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');

            // Only drop article column if it exists and was created by this migration
            // In practice, you might want to keep it or make it non-nullable
            // depending on your specific requirements
        });
    }
};
