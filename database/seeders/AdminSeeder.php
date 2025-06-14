<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles table if it doesn't exist
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                // table structure
            });
        }

        // Get the admin role
        $adminRole = Role::where('slug', 'admin')->first();

        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@airquality.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@airquality.com',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
            ]);
        } else {
            // Update existing admin user with role if needed
            $adminUser = User::where('email', 'admin@airquality.com')->first();
            if (!$adminUser->role_id) {
                $adminUser->role_id = $adminRole->id;
                $adminUser->save();
            }
        }
    }
}
