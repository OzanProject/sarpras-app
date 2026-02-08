<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Roles
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $userRole = \App\Models\Role::where('name', 'user')->first();

        // Admin Account (Matches README)
        if (!User::where('email', 'admin@admin.com')->exists() && $adminRole) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_approved' => true,
            ]);
        }

        // User Account (Matches README)
        if (!User::where('email', 'user@user.com')->exists() && $userRole) {
            User::create([
                'name' => 'User Biasa',
                'email' => 'user@user.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'is_approved' => true,
            ]);
        }

        // Original Seed (Keep for compatibility)
        if (!User::where('email', 'ardiansyahdzan@gmail.com')->exists() && $adminRole) {
            User::create([
                'name' => 'Adriansyah',
                'email' => 'ardiansyahdzan@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_approved' => true,
            ]);
        }
    }
}
