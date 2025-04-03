<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mark the confirmation_compliance_measurement_nest_values table as migrated
        DB::table('migrations')->insert([
            'migration' => '2024_03_19_000000_create_confirmation_compliance_measurement_nest_values_table',
            'batch' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the migration record if needed
        DB::table('migrations')
            ->where('migration', '2024_03_19_000000_create_confirmation_compliance_measurement_nest_values_table')
            ->delete();
    }
};
