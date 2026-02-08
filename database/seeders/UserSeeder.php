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
        // Admin Account (Matches README)
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
            ]);
        }

        // User Account (Matches README)
        if (!User::where('email', 'user@user.com')->exists()) {
            User::create([
                'name' => 'User Biasa',
                'email' => 'user@user.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_approved' => true,
            ]);
        }

        // Original Seed (Keep for compatibility)
        if (!User::where('email', 'ardiansyahdzan@gmail.com')->exists()) {
            User::create([
                'name' => 'Adriansyah',
                'email' => 'ardiansyahdzan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
            ]);
        }
    }
}
