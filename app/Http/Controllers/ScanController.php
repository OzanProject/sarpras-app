<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|exists:barangs,kode_barang',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->firstOrFail();

        // Check for active loans (Items that are currently borrowed)
        $activeLoans = \App\Models\Peminjaman::where('barang_id', $barang->id)
                        ->where('status', 'dipinjam')
                        ->exists();

        if ($activeLoans) {
            // Redirect to Active Loans page for Returning
            return redirect()->route('peminjaman.active-loans', $barang->id)
                             ->with('info', 'Barang sedang dipinjam. Pilih transaksi untuk dikembalikan.');
        }

        // If no active loans, redirect to Borrowing form
        return redirect()->route('peminjaman.create', ['barang_id' => $barang->id])
                         ->with('success', 'Barang ditemukan: ' . $barang->nama);
    }
}
