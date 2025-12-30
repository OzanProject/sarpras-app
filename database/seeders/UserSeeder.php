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
        // Use verify to prevent duplicate error if re-seeded, or just let it fail if unique constraint
        if (!User::where('email', 'ardiansyahdzan@gmail.com')->exists()) {
            User::create([
                'name' => 'Adriansyah',
                'email' => 'ardiansyahdzan@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
