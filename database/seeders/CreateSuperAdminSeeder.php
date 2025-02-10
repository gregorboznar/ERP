<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// Create the user
$user = User::create([
    'name' => 'Gregor Boznar',
    'email' => 'gregor.boznar@gmail.com',
    'password' => bcrypt('brinar00'),
]);

// Create super-admin role if it doesn't exist
$role = Role::firstOrCreate(['name' => 'super_admin']);

// Assign the role to the user
$user->assignRole('super_admin');

// Give all permissions to super_admin role (optional)
$role->givePermissionTo(Permission::all());
