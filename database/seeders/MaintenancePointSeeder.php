<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenancePoint;
use App\Models\Machine;
use Carbon\Carbon;

class MaintenancePointSeeder extends Seeder
{
  public function run(): void
  {
    $machine = Machine::firstOrCreate([
      'machine_type' => 'BUHLER 250/1',
      'type' => 'TLAČNO LIVARSKI STROJ',
      'year_of_manufacture' => 1989,
      'manufacturer' => 'Buhler',
      'inventory_number' => '250/1',
      'control_period' => Carbon::now()->addDays(1), // Daily control period
    ]);

    $maintenancePoints = [
      [
        'name' => 'Nivo mazalnega sredstva za premaz tlačnega orodja',
        'description' => 'Kovinski sod poleg metalne brizgalke, mazno sredstvo: DIE-LUBRIC 1058 BS-2',
        'location' => 'Ob stroju',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Nivo centralnega mazanja',
        'description' => 'Kovinska posoda ki se nahaja za vrtljivo konzolo, pregled nivoja olja v rezervoarju. Mazno sredstvo: Weylubric VG 220',
        'location' => 'Centralni sistem',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Nivo maznega olja za mazanje beta',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: PISTON LUBRICANT GF7',
        'location' => 'Beta sistem',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Nivo olja v pripravni grupi livarskega stroja',
        'description' => 'Nivo oz olje mora biti vidno. Mazno sredstvo: AIROIL',
        'location' => 'Pripravna grupa',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Nivo tlaka sistemskega števila',
        'description' => 'min:100 bar, max:120 bar - Manometer',
        'location' => 'Sistemski števec',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Nivo olja v pripravni grupi livarskega stroja',
        'description' => 'Hidravlične stiskalnice (drugi ločnik pripravne grupe)',
        'location' => 'Hidravlična stiskalnica',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Centralno mazanje stiskalnice Schenk SHP30',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: KARTUŠA (polni Filmza)',
        'location' => 'Stiskalnica Schenk',
        'machine_id' => $machine->id,
      ],
      [
        'name' => 'Centralno mazanje stiskalnice ROBOPRES',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: Weylubric VG 220',
        'location' => 'Stiskalnica Robopres',
        'machine_id' => $machine->id,
      ],
    ];

    foreach ($maintenancePoints as $point) {
      MaintenancePoint::create($point);
    }
  }
}
