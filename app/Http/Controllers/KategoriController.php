<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.view');
        $kategoris = Kategori::latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.create');
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.create');
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.edit');
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.edit');
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        \Illuminate\Support\Facades\Gate::authorize('kategori.delete');
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
