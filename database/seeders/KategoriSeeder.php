<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Elektronik', 'keterangan' => 'Peralatan elektronik seperti Laptop, Proyektor, dll'],
            ['nama' => 'Mebel', 'keterangan' => 'Meja, Kursi, Lemari'],
            ['nama' => 'Alat Kebersihan', 'keterangan' => 'Sapu, Pel, Tempat Sampah'],
            ['nama' => 'Alat Tulis Kantor', 'keterangan' => 'Spidol, Penghapus Papan Tulis'],
            ['nama' => 'Peralatan Olahraga', 'keterangan' => 'Bola, Raket, Net'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
