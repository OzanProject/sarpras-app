<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserScanController extends Controller
{
    public function index()
    {
        return view('user.scan.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
        ]);

        $kode_barang = trim($request->kode_barang);

        // Smart Check: Are they scanning a Member Card Summary?
        if (str_starts_with($kode_barang, 'Status Peminjaman') || str_starts_with($kode_barang, 'Member Valid')) {
            return redirect()->route('user.peminjaman.index')->with('success', 'Kartu Anggota terbaca! Berikut adalah daftar peminjaman Anda.');
        }

        $barang = Barang::where('kode_barang', $kode_barang)->first();

        // Fallback 1: Try zero padding (if numeric) for Kode Barang
        if (!$barang && is_numeric($kode_barang)) {
            $padded_code = str_pad($kode_barang, 6, '0', STR_PAD_LEFT);
            $barang = Barang::where('kode_barang', $padded_code)->first();
        }

        // Fallback 2: Try searching by ID
        if (!$barang && is_numeric($kode_barang)) {
             $barang = Barang::find((int)$kode_barang);
        }

        if (!$barang) {
             return redirect()->route('user.scan.index')->with('error', 'Kode barang/ID tidak valid: ' . $kode_barang);
        }

        $user = Auth::user();

        // Cari peminjaman aktif user untuk barang ini
        $loan = Peminjaman::where('barang_id', $barang->id)
                    ->where('user_id', $user->id)
                    ->where('status', 'dipinjam')
                    ->first();

        if ($loan) {
            // Proses Pengembalian
            $loan->update([
                'status' => 'kembali',
                'tgl_kembali' => now(),
            ]);

            // Update Stok Barang (+1)
            $barang->increment('stok');

            return redirect()->route('user.scan.index')->with('success', 'Berhasil! Barang ' . $barang->nama . ' telah dikembalikan.');
        } else {
            return redirect()->route('user.scan.index')->with('error', 'Gagal! Anda tidak sedang meminjam barang ini (' . $barang->nama . ').');
        }
    }
}
