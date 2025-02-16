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
    // Create the super_admin role if it doesn't exist
    $role = Role::firstOrCreate(['name' => 'super_admin']);

    // Create the user
    $user = User::create([
      'name' => 'Gregor Boznar',
      'email' => 'gregor.boznar@gmail.com',
      'password' => Hash::make('brinar00'),
    ]);

    // Assign the super_admin role to the user
    $user->assignRole('super_admin');
  }
}
