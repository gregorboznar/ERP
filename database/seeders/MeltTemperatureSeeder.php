<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeltTemperature;
use App\Models\User; // Ensure you have a User model

class MeltTemperatureSeeder extends Seeder
{
  public function run()
  {
    // Example: Create 10 records for a random user
    $users = User::all();

    foreach ($users as $user) {
      for ($i = 0; $i < 4; $i++) { // Assuming 4 entries per shift
        MeltTemperature::create([
          'user_id' => $user->id,
          'temperature' => rand(150, 250), // Random temperature for example
          'recorded_at' => now()->subHours($i), // Example recorded time
        ]);
      }
    }
  }
}
