<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeltTemperature;
use App\Models\User; 

class MeltTemperatureSeeder extends Seeder
{
  public function run()
  {
    $users = User::all();

    foreach ($users as $user) {
      for ($i = 0; $i < 4; $i++) { 
        MeltTemperature::create([
          'user_id' => $user->id,
          'temperature' => rand(150, 250),
          'recorded_at' => now()->subHours($i), 
        ]);
      }
    }
  }
}
