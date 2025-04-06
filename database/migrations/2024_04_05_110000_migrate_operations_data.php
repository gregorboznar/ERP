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
    // Migrate data from die_castings table
    if (Schema::hasTable('die_castings')) {
      $dieCastings = DB::table('die_castings')->get();
      foreach ($dieCastings as $dieCasting) {
        $data = [
          'date' => $dieCasting->date,
          'start_time' => $dieCasting->start_time,
          'counter_start' => $dieCasting->counter_start,
          'end_time' => $dieCasting->end_time,
          'counter_end' => $dieCasting->counter_end,
          'good_parts_count' => $dieCasting->good_parts_count,
          'operation_type' => 'die_casting',
          'series_tender_id' => $dieCasting->series_tender_id,
          'created_at' => $dieCasting->created_at,
          'updated_at' => $dieCasting->updated_at,
        ];

        // Handle optional fields
        if (property_exists($dieCasting, 'technological_waste')) {
          $data['technological_waste'] = $dieCasting->technological_waste;
        } else {
          $data['technological_waste'] = 0;
        }

        if (property_exists($dieCasting, 'waste')) {
          $data['waste'] = $dieCasting->waste;
        }

        if (property_exists($dieCasting, 'palet_number')) {
          $data['palet_number'] = $dieCasting->palet_number;
        }

        if (property_exists($dieCasting, 'batch_of_material')) {
          $data['batch_of_material'] = $dieCasting->batch_of_material;
        }

        if (property_exists($dieCasting, 'waste_slag_weight')) {
          $data['waste_slag_weight'] = $dieCasting->waste_slag_weight;
        }

        if (property_exists($dieCasting, 'stopage_reason')) {
          $data['stopage_reason'] = $dieCasting->stopage_reason;
        }

        if (property_exists($dieCasting, 'notes')) {
          $data['notes'] = $dieCasting->notes;
        }

        if (property_exists($dieCasting, 'deleted_at')) {
          $data['deleted_at'] = $dieCasting->deleted_at;
        }

        DB::table('production_operations')->insert($data);
      }
    }

    // Migrate data from packagings table
    if (Schema::hasTable('packagings')) {
      $packagings = DB::table('packagings')->get();
      foreach ($packagings as $packaging) {
        $data = [
          'date' => $packaging->date,
          'start_time' => $packaging->start_time,
          'counter_start' => $packaging->counter_start,
          'end_time' => $packaging->end_time,
          'counter_end' => $packaging->counter_end,
          'good_parts_count' => $packaging->good_parts_count,
          'operation_type' => 'packaging',
          'series_tender_id' => $packaging->series_tender_id,
          'created_at' => $packaging->created_at,
          'updated_at' => $packaging->updated_at,
        ];

        // Handle optional fields
        if (property_exists($packaging, 'technological_waste')) {
          $data['technological_waste'] = $packaging->technological_waste;
        } else {
          $data['technological_waste'] = 0;
        }

        if (property_exists($packaging, 'waste')) {
          $data['waste'] = $packaging->waste;
        }

        if (property_exists($packaging, 'palet_number')) {
          $data['palet_number'] = $packaging->palet_number;
        }

        if (property_exists($packaging, 'batch_of_material')) {
          $data['batch_of_material'] = $packaging->batch_of_material;
        }

        if (property_exists($packaging, 'waste_slag_weight')) {
          $data['waste_slag_weight'] = $packaging->waste_slag_weight;
        }

        if (property_exists($packaging, 'stopage_reason')) {
          $data['stopage_reason'] = $packaging->stopage_reason;
        }

        if (property_exists($packaging, 'notes')) {
          $data['notes'] = $packaging->notes;
        }

        if (property_exists($packaging, 'deleted_at')) {
          $data['deleted_at'] = $packaging->deleted_at;
        }

        DB::table('production_operations')->insert($data);
      }
    }

    // Migrate data from grindings table
    if (Schema::hasTable('grindings')) {
      $grindings = DB::table('grindings')->get();
      foreach ($grindings as $grinding) {
        $data = [
          'date' => $grinding->date,
          'start_time' => $grinding->start_time,
          'counter_start' => $grinding->counter_start,
          'end_time' => $grinding->end_time,
          'counter_end' => $grinding->counter_end,
          'good_parts_count' => $grinding->good_parts_count,
          'operation_type' => 'grinding',
          'series_tender_id' => $grinding->series_tender_id,
          'created_at' => $grinding->created_at,
          'updated_at' => $grinding->updated_at,
        ];

        // Handle optional fields
        if (property_exists($grinding, 'technological_waste')) {
          $data['technological_waste'] = $grinding->technological_waste;
        } else {
          $data['technological_waste'] = 0;
        }

        if (property_exists($grinding, 'waste')) {
          $data['waste'] = $grinding->waste;
        }

        if (property_exists($grinding, 'palet_number')) {
          $data['palet_number'] = $grinding->palet_number;
        }

        if (property_exists($grinding, 'batch_of_material')) {
          $data['batch_of_material'] = $grinding->batch_of_material;
        }

        if (property_exists($grinding, 'waste_slag_weight')) {
          $data['waste_slag_weight'] = $grinding->waste_slag_weight;
        }

        if (property_exists($grinding, 'stopage_reason')) {
          $data['stopage_reason'] = $grinding->stopage_reason;
        }

        if (property_exists($grinding, 'notes')) {
          $data['notes'] = $grinding->notes;
        }

        if (property_exists($grinding, 'deleted_at')) {
          $data['deleted_at'] = $grinding->deleted_at;
        }

        DB::table('production_operations')->insert($data);
      }
    }

    // Drop old tables
    Schema::dropIfExists('die_castings');
    Schema::dropIfExists('packagings');
    Schema::dropIfExists('grindings');
  }

  /**
   * Reverse the migrations.
   * This is a destructive migration, so we don't provide a down migration
   */
  public function down(): void
  {
    // No down migration provided as this is a data migration
  }
};
