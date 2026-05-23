<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('scan.view');
        return view('admin.scan.index');
    }

    public function process(Request $request)
    {
        $kode = $request->kode_barang;
        
        // If the scanned input is a URL (e.g. from the new public QR code format)
        if (filter_var($kode, FILTER_VALIDATE_URL)) {
            $path = parse_url($kode, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            $kode = end($segments); // get the last part which should be kode_barang
        }

        $barang = Barang::where('kode_barang', $kode)->firstOrFail();

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
