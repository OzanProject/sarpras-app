<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->get();
        return view('admin.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:rooms,nama',
            'keterangan' => 'nullable|string',
        ]);

        Room::create($request->all());

        return redirect()->route('room.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:rooms,nama,' . $room->id,
            'keterangan' => 'nullable|string',
        ]);

        $room->update($request->all());

        return redirect()->route('room.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Check if room has items
        if ($room->barangs()->count() > 0) {
            return back()->with('error', 'Gagal menghapus! Masih ada barang di ruangan ini.');
        }

        $room->delete();

        return redirect()->route('room.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
