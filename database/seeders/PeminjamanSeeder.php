<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $barang1 = Barang::where('kode_barang', 'ELK-001')->first(); // Proyektor
        $barang2 = Barang::where('kode_barang', 'ORG-001')->first(); // Bola Basket

        if ($barang1) {
            Peminjaman::create([
                'barang_id' => $barang1->id,
                'nama_peminjam' => 'Budi Santoso (Guru Biologi)',
                'tgl_pinjam' => Carbon::now()->subDays(2),
                'tgl_kembali' => null,
                'jumlah' => 1,
                'status' => 'dipinjam',
                'keterangan' => 'Untuk mengajar di kelas X IPA 1',
            ]);
        }

        if ($barang2) {
            Peminjaman::create([
                'barang_id' => $barang2->id,
                'nama_peminjam' => 'Dian Sastro (Siswa XII IPS 2)',
                'tgl_pinjam' => Carbon::now()->subDays(5),
                'tgl_kembali' => Carbon::now(),
                'jumlah' => 2,
                'status' => 'kembali',
                'keterangan' => 'Praktek olahraga basket',
            ]);
        }
    }
}
