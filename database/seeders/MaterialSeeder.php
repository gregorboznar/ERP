<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::create([
            'title' => 'Aluminijeva zlitina  EN AB 43400',

            // Add other fields as necessary
        ]);

        Material::create([
            'title' => 'Aluminijeva zlitina  EN AB 46000',

            // Add other fields as necessary
        ]);

        // Add more materials as needed
    }
}
