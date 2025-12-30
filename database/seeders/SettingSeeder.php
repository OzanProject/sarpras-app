<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            'nama_sekolah' => 'SMK Negeri 1 Contoh',
            'alamat' => 'Jl. Pendidikan No. 1, Kota Contoh',
            'email' => 'info@smkn1contoh.sch.id',
            'telepon' => '(021) 1234567',
            'logo' => null, // Path to logo
            'footer_text' => '© 2024 Sarana Prasarana Sekolah. All rights reserved.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
