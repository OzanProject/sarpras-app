<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        $search = $request->input('search');

        $query = Barang::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
        }

        $barangs = $query->with('kategori', 'room')->latest()->paginate(12);

        return view('welcome', compact('barangs', 'search'));
    }

    public function scanPage(Request $request)
    {
        $barangs = Barang::orderBy('nama', 'asc')->get();
        $type = $request->query('type', 'pinjam');
        return view('public.scan', compact('barangs', 'type'));
    }

    public function scanBarcode(Request $request, $kode_barang)
    {
        $barang = Barang::with(['kategori', 'room'])->where('kode_barang', $kode_barang)->firstOrFail();
        $users = User::orderBy('name', 'asc')->get();
        $activePeminjamans = Peminjaman::where('barang_id', $barang->id)
            ->where('status', 'dipinjam')
            ->get();
            
        $type = $request->query('type', 'pinjam');
            
        return view('public.scan-barcode', compact('barang', 'users', 'activePeminjamans', 'type'));
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi!');
        }

        Peminjaman::create([
            'barang_id' => $request->barang_id,
            'nama_peminjam' => $request->nama_peminjam,
            'user_id' => $request->user_id,
            'tgl_pinjam' => now(),
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim. Silakan tunggu persetujuan admin.');
    }

    public function kembali(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        if ($peminjaman->status === 'kembali') {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status peminjaman tidak valid untuk dikembalikan.');
        }

        $peminjaman->update([
            'status' => 'kembali',
            'tgl_kembali' => now(),
        ]);

        $barang = Barang::findOrFail($peminjaman->barang_id);
        $barang->increment('stok', $peminjaman->jumlah);

        return back()->with('success', 'Barang berhasil dikembalikan. Terima kasih!');
    }
}
