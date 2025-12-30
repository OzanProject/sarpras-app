<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
        ]);

        $barang = Barang::find($request->barang_id);

        if ($barang->stok <= 0) {
            return back()->with('error', 'Stok barang habis.');
        }

        // Cek apakah user sudah meminjam barang yang sama dan statusnya masih pending/dipinjam
        $existing = Peminjaman::where('user_id', Auth::id())
            ->where('barang_id', $request->barang_id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengajukan/meminjam barang ini.');
        }

        Peminjaman::create([
            'barang_id' => $request->barang_id,
            'user_id' => Auth::id(),
            'nama_peminjam' => Auth::user()->name, // Tetap simpan nama untuk kemudahan
            'tgl_pinjam' => Carbon::now(),
            'jumlah' => 1, // Default 1
            'status' => 'pending',
            'keterangan' => 'Peminjaman Mandiri via Web',
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan Admin.');
    }
}
