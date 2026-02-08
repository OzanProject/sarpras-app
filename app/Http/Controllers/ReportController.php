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

        $query = Peminjaman::with('barang')
            ->whereDate('tgl_pinjam', '>=', $startDate)
            ->whereDate('tgl_pinjam', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        return view('admin.report.index', compact('peminjamans', 'startDate', 'endDate', 'status'));
    }

    public function print(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('report.view');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = Peminjaman::with('barang')
            ->whereDate('tgl_pinjam', '>=', $startDate)
            ->whereDate('tgl_pinjam', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        return view('admin.report.print', compact('peminjamans', 'startDate', 'endDate', 'status'));
    }
}
