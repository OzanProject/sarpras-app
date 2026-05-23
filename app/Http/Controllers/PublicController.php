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

    public function scanBarcode($kode_barang)
    {
        $barang = Barang::with(['kategori', 'room'])->where('kode_barang', $kode_barang)->firstOrFail();
        return view('public.scan-barcode', compact('barang'));
    }
}
