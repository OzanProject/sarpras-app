<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.view');
        $barangs = Barang::with('kategori')->latest()->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.create');
        $kategoris = Kategori::all();
        $rooms = \App\Models\Room::all();
        return view('admin.barang.create', compact('kategoris', 'rooms'));
    }

    public function print(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.print');
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:barangs,id',
        ]);

        $barangs = Barang::whereIn('id', $request->ids)->get();

        return view('admin.barang.print', compact('barangs'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.create');
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'lokasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();

        if ($request->hasFile('foto')) {
            $input['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($input);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.view');
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.edit');
        $kategoris = Kategori::all();
        $rooms = \App\Models\Room::all();
        return view('admin.barang.edit', compact('barang', 'kategoris', 'rooms'));
    }

    public function update(Request $request, Barang $barang)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.edit');
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'lokasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $input['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($input);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        \Illuminate\Support\Facades\Gate::authorize('barang.delete');
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
