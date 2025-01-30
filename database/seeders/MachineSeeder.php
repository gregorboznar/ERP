<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
  public function run(): void
  {
    Machine::create([
      'machine_type' => 'CNC Machine',
      'type' => 'Industrial',
      'year_of_manufacture' => 2024,
      'manufacturer' => 'Industrial Solutions',
      'inventory_number' => 'INV001',
      'control_period' => now(),
    ]);

    Machine::create([
      'machine_type' => 'Laser Cutter',
      'type' => 'Professional',
      'year_of_manufacture' => 2023,
      'manufacturer' => 'Tech Manufacturing',
      'inventory_number' => 'INV002',
      'control_period' => now(),
    ]);
  }
}
