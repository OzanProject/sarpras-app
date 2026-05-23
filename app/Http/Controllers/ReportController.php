<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('report.view');
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->input('status');

        $type = $request->input('type', 'peminjaman');

        $query = Peminjaman::with('barang')
            ->whereDate('tgl_pinjam', '>=', $startDate)
            ->whereDate('tgl_pinjam', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        $barangs = null;
        if ($type == 'aset') {
            $barangQuery = \App\Models\Barang::with(['kategori', 'room', 'maintenances' => function($q) {
                $q->latest()->whereNotNull('foto_bukti');
            }])->latest();
            // If they want to filter aset by status (kondisi), we can use the same $status variable
            if ($status) {
                $barangQuery->where('kondisi', $status);
            }
            $barangs = $barangQuery->get();
        }

        return view('admin.report.index', compact('peminjamans', 'barangs', 'startDate', 'endDate', 'status', 'type'));
    }

    public function print(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('report.view');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $type = $request->input('type', 'peminjaman');

        $query = Peminjaman::with('barang')
            ->whereDate('tgl_pinjam', '>=', $startDate)
            ->whereDate('tgl_pinjam', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        $barangs = null;
        if ($type == 'aset') {
            $barangQuery = \App\Models\Barang::with(['kategori', 'room', 'maintenances' => function($q) {
                $q->latest()->whereNotNull('foto_bukti');
            }])->latest();
            if ($status) {
                $barangQuery->where('kondisi', $status);
            }
            $barangs = $barangQuery->get();
        }

        return view('admin.report.print', compact('peminjamans', 'barangs', 'startDate', 'endDate', 'status', 'type'));
    }
}
