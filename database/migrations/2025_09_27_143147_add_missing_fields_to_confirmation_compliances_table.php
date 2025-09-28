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
            $table->foreignId('series_tender_id')->nullable()->constrained('series_tenders');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('correct_technological_parameters')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirmation_compliances', function (Blueprint $table) {
            $table->dropForeign(['series_tender_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['series_tender_id', 'user_id', 'correct_technological_parameters']);
        });
    }
};
