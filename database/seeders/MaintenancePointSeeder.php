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
    // Get all machines
    $machines = Machine::all();

    if ($machines->isEmpty()) {
      // Make sure we have at least one machine
      $this->call(MachineSeeder::class);
      $machines = Machine::all();
    }

    $maintenancePoints = [
      [
        'name' => 'Nivo mazalnega sredstva za premaz tlačnega orodja',
        'description' => 'Kovinski sod poleg metalne brizgalke, mazno sredstvo: DIE-LUBRIC 1058 BS-2',
        'location' => 'Ob stroju',
      ],
      [
        'name' => 'Nivo centralnega mazanja',
        'description' => 'Kovinska posoda ki se nahaja za vrtljivo konzolo, pregled nivoja olja v rezervoarju. Mazno sredstvo: Weylubric VG 220',
        'location' => 'Centralni sistem',
      ],
      [
        'name' => 'Nivo maznega olja za mazanje beta',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: PISTON LUBRICANT GF7',
        'location' => 'Beta sistem',
      ],
      [
        'name' => 'Nivo olja v pripravni grupi livarskega stroja',
        'description' => 'Nivo oz olje mora biti vidno. Mazno sredstvo: AIROIL',
        'location' => 'Pripravna grupa',
      ],
      [
        'name' => 'Nivo tlaka sistemskega števila',
        'description' => 'min:100 bar, max:120 bar - Manometer',
        'location' => 'Sistemski števec',
      ],
      [
        'name' => 'Nivo olja v pripravni grupi livarskega stroja',
        'description' => 'Hidravlične stiskalnice (drugi ločnik pripravne grupe)',
        'location' => 'Hidravlična stiskalnica',
      ],
      [
        'name' => 'Centralno mazanje stiskalnice Schenk SHP30',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: KARTUŠA (polni Filmza)',
        'location' => 'Stiskalnica Schenk',
      ],
      [
        'name' => 'Centralno mazanje stiskalnice ROBOPRES',
        'description' => 'Pregled v primeru da je 10 cm pod vrhom. Mazno sredstvo: Weylubric VG 220',
        'location' => 'Stiskalnica Robopres',
      ],
    ];

    foreach ($maintenancePoints as $point) {
      $maintenancePoint = MaintenancePoint::create($point);

      // Associate this point with all machines
      // In a real application, you might want to be more selective about which points go with which machines
      foreach ($machines as $machine) {
        $machine->maintenancePoints()->attach($maintenancePoint->id);
      }
    }
  }
}
