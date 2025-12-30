<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Kategori::where('nama', 'Elektronik')->first();
        $mebel = Kategori::where('nama', 'Mebel')->first();
        $olahraga = Kategori::where('nama', 'Peralatan Olahraga')->first();

        // Elektronik
        if ($elektronik) {
            Barang::create([
                'kategori_id' => $elektronik->id,
                'kode_barang' => 'ELK-001',
                'nama' => 'Proyektor Epson EB-X400',
                'stok' => 5,
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Guru',
                'foto' => null, // Placeholder or null
            ]);
            Barang::create([
                'kategori_id' => $elektronik->id,
                'kode_barang' => 'ELK-002',
                'nama' => 'Laptop Asus Vivobook',
                'stok' => 3,
                'kondisi' => 'baik',
                'lokasi' => 'Lab Komputer',
                'foto' => null,
            ]);
        }

        // Mebel
        if ($mebel) {
            Barang::create([
                'kategori_id' => $mebel->id,
                'kode_barang' => 'MBL-001',
                'nama' => 'Kursi Guru Kayu Jati',
                'stok' => 20,
                'kondisi' => 'baik',
                'lokasi' => 'Gudang Utama',
                'foto' => null,
            ]);
            Barang::create([
                'kategori_id' => $mebel->id,
                'kode_barang' => 'MBL-002',
                'nama' => 'Meja Siswa Double',
                'stok' => 10, // Sisa stok sedikit
                'kondisi' => 'perbaikan',
                'lokasi' => 'Gudang Belakang',
                'foto' => null,
            ]);
        }

        // Olahraga
        if ($olahraga) {
            Barang::create([
                'kategori_id' => $olahraga->id,
                'kode_barang' => 'ORG-001',
                'nama' => 'Bola Basket Molten',
                'stok' => 15,
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Olahraga',
                'foto' => null,
            ]);
        }
    }
}
