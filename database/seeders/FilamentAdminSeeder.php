<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FilamentAdminSeeder extends Seeder
{
  public function run(): void
  {

    /*   $role = Role::firstOrCreate(['name' => 'admin']);

   
    $user = User::create([
      'name' => 'Gregor Boznar',
      'email' => 'gregor.boznar@gmail.com',
      'password' => Hash::make('brinar00'),
    ]); */


    /*   $user->assignRole('admin'); */
  }
}
