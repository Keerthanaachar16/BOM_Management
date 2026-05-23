<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Admin']);

        Role::create(['name' => 'Purchase Department']);

        Role::create(['name' => 'Engineer']);

        Role::create(['name' => 'Store Manager']);
    }
}
