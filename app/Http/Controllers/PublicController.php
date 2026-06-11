<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Barang::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
        }

        $barangs = $query->with('kategori', 'room')->latest()->paginate(12);

        return view('welcome', compact('barangs', 'search'));
    }

    public function scanPage()
    {
        return view('public.scan');
    }

    public function scanBarcode($kode_barang)
    {
        $barang = Barang::with(['kategori', 'room'])->where('kode_barang', $kode_barang)->firstOrFail();
        return view('public.scan-barcode', compact('barang'));
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi!');
        }

        \App\Models\Peminjaman::create([
            'barang_id' => $request->barang_id,
            'nama_peminjam' => $request->nama_peminjam,
            'tgl_pinjam' => now(),
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim. Silakan tunggu persetujuan admin.');
    }
}
