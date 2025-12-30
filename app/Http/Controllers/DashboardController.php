<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // --- USER DASHBOARD ---
        if ($user->role == 'user') {
            $activeLoans = Peminjaman::where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'dipinjam'])
                            ->with('barang')
                            ->count();
                            
            $totalHistory = Peminjaman::where('user_id', $user->id)->count();
            
            $currentLoans = Peminjaman::where('user_id', $user->id)
                            ->where('status', 'dipinjam')
                            ->with('barang')
                            ->latest()
                            ->get();

            // Generate Dynamic QR Content (List of Items)
            if ($currentLoans->count() > 0) {
                $loanSummary = "Peminjaman " . $user->name . " (" . date('d-m-Y') . "):\n";
                foreach ($currentLoans as $index => $loan) {
                    $loanSummary .= ($index + 1) . ". " . $loan->barang->nama . "\n";
                }
            } else {
                $loanSummary = "Tidak ada peminjaman aktif.";
            }

            return view('user.dashboard', compact('activeLoans', 'totalHistory', 'currentLoans', 'loanSummary'));
        }

        // --- ADMIN DASHBOARD ---
        // 1. Basic Stats
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $rusak = Barang::where('kondisi', 'rusak')->count();
        $recentPeminjamans = Peminjaman::with('barang', 'user')->latest()->limit(5)->get();

        // 2. Chart Data: Items per Category
        $itemsPerCategory = Kategori::withCount('barangs')->get();
        $categoryLabels = $itemsPerCategory->pluck('nama');
        $categoryData = $itemsPerCategory->pluck('barangs_count');

        // 3. Chart Data: Loans per Month (Current Year)
        $loansPerMonth = Peminjaman::select(
            DB::raw('MONTH(tgl_pinjam) as month'), 
            DB::raw('count(*) as count')
        )
        ->whereYear('tgl_pinjam', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month');

        // Prepare 12 months data (fill zeros if no data)
        $monthLabels = [];
        $monthData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthLabels[] = Carbon::create()->month($i)->format('F'); // Jan, Feb...
            $monthData[] = $loansPerMonth[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalBarang', 
            'totalKategori', 
            'dipinjam', 
            'rusak', 
            'recentPeminjamans',
            'categoryLabels',
            'categoryData',
            'monthLabels',
            'monthData'
        ));
    }
}
