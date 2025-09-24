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
        DB::statement('ALTER TABLE machines MODIFY COLUMN year_of_manufacture VARCHAR(10) NULL');
        DB::statement("UPDATE machines SET year_of_manufacture = CONCAT(year_of_manufacture, '-01-01') WHERE year_of_manufacture IS NOT NULL AND year_of_manufacture REGEXP '^[0-9]{4}$'");
        DB::statement('ALTER TABLE machines MODIFY COLUMN year_of_manufacture DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement("UPDATE machines SET year_of_manufacture = YEAR(year_of_manufacture) WHERE year_of_manufacture IS NOT NULL");
        DB::statement('ALTER TABLE machines MODIFY COLUMN year_of_manufacture INTEGER NULL');
    }
};
