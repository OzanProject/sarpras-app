<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Barang;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('barang')->latest()->get();
        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('admin.maintenance.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tgl_lapor' => 'required|date',
            'deskripsi_kerusakan' => 'required|string',
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $maintenance = Maintenance::create($request->all());

        if ($maintenance->status != 'selesai') {
            $barang = Barang::find($request->barang_id);
            $barang->update(['kondisi' => 'perbaikan']);
        }

        return redirect()->route('maintenance.index')->with('success', 'Laporan kerusakan berhasil dibuat.');
    }

    public function edit(Maintenance $maintenance)
    {
        $barangs = Barang::all();
        return view('admin.maintenance.edit', compact('maintenance', 'barangs'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tgl_lapor' => 'required|date',
            'deskripsi_kerusakan' => 'required|string',
            'biaya' => 'nullable|numeric|min:0',
            'tgl_selesai' => 'nullable|date',
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $maintenance->update($request->all());

        if ($request->status == 'selesai') {
            $barang = Barang::find($request->barang_id);
            $barang->update(['kondisi' => 'baik']);
            
            // Opsional: Jika status selesai, otomatis set tgl_selesai hari ini jika belum diisi
            if (!$maintenance->tgl_selesai) {
                $maintenance->update(['tgl_selesai' => now()]);
            }
        } else {
             $barang = Barang::find($request->barang_id);
             $barang->update(['kondisi' => 'perbaikan']);
        }

        return redirect()->route('maintenance.index')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('success', 'Data perbaikan dihapus.');
    }
}
