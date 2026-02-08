<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.view');
        $peminjamans = Peminjaman::with('barang', 'user')->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        // Only show items with stock > 0
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('admin.peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'tgl_pinjam' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi!');
        }

        DB::transaction(function () use ($request, $barang) {
            // Create Peminjaman
            Peminjaman::create([
                'barang_id' => $request->barang_id,
                'nama_peminjam' => $request->nama_peminjam,
                'tgl_pinjam' => $request->tgl_pinjam,
                'jumlah' => $request->jumlah,
                'status' => 'dipinjam',
                'keterangan' => $request->keterangan,
            ]);

            // Decrease Stock
            $barang->decrement('stok', $request->jumlah);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        $request->validate([
            'status' => 'required|in:dipinjam,kembali',
            'tgl_kembali' => 'required_if:status,kembali|nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {

            // Check if status changing from 'dipinjam' to 'kembali'
            if ($peminjaman->status == 'dipinjam' && $request->status == 'kembali') {
                $peminjaman->update([
                    'status' => 'kembali',
                    'tgl_kembali' => $request->tgl_kembali ?? now(),
                    'keterangan' => $request->keterangan ?? $peminjaman->keterangan,
                ]);

                // Return Stock
                $peminjaman->barang->increment('stok', $peminjaman->jumlah);
            }
            // If just updating text or dates without status change logic (simplification)
            else {
                $peminjaman->update($request->only('status', 'tgl_kembali', 'keterangan'));
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        // Warn: Deleting a loan record might mess up stock history if not handled. 
        // For now, we assume deleting is only for cleanup and doesn't restore stock automatically unless explicitly returned.
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }

    /**
     * Show list of active loans for a specific item (for Scan Return flow).
     */
    public function activeLoans($barang_id)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.view');
        $barang = Barang::findOrFail($barang_id);
        $activeLoans = Peminjaman::where('barang_id', $barang_id)
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        return view('admin.peminjaman.active_loans', compact('barang', 'activeLoans'));
    }

    /**
     * Process return of an item.
     */
    public function returnItem(Request $request, $id)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'kembali') {
            return back()->with('error', 'Barang ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status' => 'kembali',
                'tgl_kembali' => now(),
            ]);

            // Restore Stock
            $peminjaman->barang->increment('stok', $peminjaman->jumlah);
        });

        return redirect()->route('scan.index')->with(
            'success',
            'Barang berhasil dikembalikan dari ' . $peminjaman->nama_peminjam
        );
    }
    public function approve($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'pending') {
            return back()->with('error', 'Status peminjaman bukan pending.');
        }

        $barang = $peminjaman->barang;

        if ($barang->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi untuk menyetujui permintaan ini.');
        }

        DB::transaction(function () use ($peminjaman, $barang) {
            $peminjaman->update([
                'status' => 'dipinjam',
                'tgl_pinjam' => now(), // Set start date to approval time
            ]);

            $barang->decrement('stok', $peminjaman->jumlah);
        });

        return back()->with('success', 'Permintaan peminjaman disetujui.');
    }

    public function reject($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('peminjaman.action');
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'pending') {
            return back()->with('error', 'Status peminjaman bukan pending.');
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Permintaan peminjaman ditolak.');
    }
}
