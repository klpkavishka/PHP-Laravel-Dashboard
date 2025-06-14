<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator']
        );

        // Create user role if it doesn't exist
        Role::firstOrCreate(
            ['slug' => 'user'],
            ['name' => 'User']
        );
    }
}
