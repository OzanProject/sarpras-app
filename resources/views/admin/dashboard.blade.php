@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
/* ===== DASHBOARD STYLES ===== */

/* Welcome banner */
.welcome-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 55%, #0c4a6e 100%);
    border-radius: 20px;
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
    border: none !important;
    box-shadow: 0 8px 32px rgba(14,165,233,.22) !important;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(14,165,233,.3) 0%, transparent 70%);
    border-radius: 50%;
}

.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 40%;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(6,182,212,.2) 0%, transparent 70%);
    border-radius: 50%;
}

.welcome-banner h3 {
    color: #fff !important;
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 4px;
}

.welcome-banner h3 span {
    background: linear-gradient(90deg, #7dd3fc, #22d3ee);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-banner p {
    color: #94a3b8 !important;
    margin: 0;
    font-size: .95rem;
}

.welcome-date {
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 12px;
    padding: 10px 18px;
    color: #fff !important;
    font-size: .875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ===== STAT CARDS ===== */
.stat-card-new {
    background: #fff;
    border-radius: 16px;
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    border: 1px solid #e0f2fe;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
    transition: all .35s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card-new::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 0 0 16px 16px;
}

.stat-card-new.blue::after   { background: linear-gradient(90deg, #0ea5e9, #06b6d4); }
.stat-card-new.cyan::after   { background: linear-gradient(90deg, #06b6d4, #14b8a6); }
.stat-card-new.green::after  { background: linear-gradient(90deg, #10b981, #06b6d4); }
.stat-card-new.orange::after { background: linear-gradient(90deg, #f59e0b, #ef4444); }

.stat-card-new:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(14,165,233,.15);
    border-color: #bae6fd;
}

.stat-icon-wrap {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.stat-icon-wrap.blue   { background: linear-gradient(135deg, #0ea5e9, #06b6d4); color: #fff; }
.stat-icon-wrap.cyan   { background: linear-gradient(135deg, #06b6d4, #14b8a6); color: #fff; }
.stat-icon-wrap.green  { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; }
.stat-icon-wrap.orange { background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; }

.stat-info p {
    font-size: .8rem;
    color: #94a3b8;
    margin: 0 0 4px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.stat-info h4 {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    line-height: 1;
}

/* ===== CHART CARDS ===== */
.chart-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e0f2fe;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
    padding: 24px;
    height: 100%;
}

.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}

.chart-card-title {
    font-size: .95rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.chart-card-title i {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #0ea5e9, #06b6d4);
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .8rem;
}

/* ===== TABLE CARD ===== */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e0f2fe;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
    overflow: hidden;
}

.table-card-header {
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f1f5f9;
    background: #fff;
}

.table-card-title {
    font-size: .95rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-card-title i {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #0ea5e9, #06b6d4);
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .8rem;
}

.link-see-all {
    color: #0ea5e9;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all .3s;
}

.link-see-all:hover {
    color: #0284c7;
    gap: 8px;
}

/* Premium Table */
.premium-table {
    width: 100%;
    border-collapse: collapse;
}

.premium-table thead tr {
    background: #f8fafc;
}

.premium-table thead th {
    padding: 12px 20px;
    font-size: .78rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .6px;
    border: none;
    border-bottom: 1px solid #e0f2fe;
    white-space: nowrap;
}

.premium-table tbody td {
    padding: 14px 20px;
    font-size: .875rem;
    color: #1e293b;
    border: none;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.premium-table tbody tr:last-child td { border-bottom: none; }

.premium-table tbody tr {
    transition: background .2s;
}
.premium-table tbody tr:hover {
    background: #f8fafc;
}

.premium-table .empty-row td {
    padding: 40px;
    text-align: center;
    color: #94a3b8;
    font-size: .875rem;
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: .75rem;
    font-weight: 600;
}

.status-badge.dipinjam {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}

.status-badge.kembali {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-badge.pending {
    background: #f0f9ff;
    color: #075985;
    border: 1px solid #bae6fd;
}

/* Action button */
.btn-detail {
    background: linear-gradient(135deg, #0ea5e9, #06b6d4);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 5px 14px;
    font-size: .78rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .3s;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #0284c7, #0891b2);
    color: #fff;
    box-shadow: 0 4px 12px rgba(14,165,233,.3);
    transform: translateY(-1px);
}
</style>
@endpush

@section('content')
<div class="p-4">

    {{-- ===== WELCOME BANNER ===== --}}
    <div class="welcome-banner mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="position:relative; z-index:1;">
            <div>
                <h3 class="mb-1">
                    Selamat Datang, <span>{{ Auth::user()->name }}!</span>
                </h3>
                <p>
                    <i class="fa fa-school me-1"></i>
                    {{ $global_settings['nama_sekolah'] ?? 'Sarana Prasarana Sekolah' }}
                    &nbsp;·&nbsp; Panel Admin
                </p>
            </div>
            <div class="welcome-date">
                <i class="fa fa-calendar-alt" style="color: #7dd3fc;"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card-new blue">
                <div class="stat-icon-wrap blue">
                    <i class="fa fa-box"></i>
                </div>
                <div class="stat-info">
                    <p>Total Barang</p>
                    <h4>{{ $totalBarang }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card-new cyan">
                <div class="stat-icon-wrap cyan">
                    <i class="fa fa-th-list"></i>
                </div>
                <div class="stat-info">
                    <p>Kategori</p>
                    <h4>{{ $totalKategori }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card-new green">
                <div class="stat-icon-wrap green">
                    <i class="fa fa-handshake"></i>
                </div>
                <div class="stat-info">
                    <p>Dipinjam</p>
                    <h4>{{ $dipinjam }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card-new orange">
                <div class="stat-icon-wrap orange">
                    <i class="fa fa-tools"></i>
                </div>
                <div class="stat-info">
                    <p>Barang Rusak</p>
                    <h4>{{ $rusak }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <i class="fa fa-chart-bar"></i>
                        Stok Barang per Kategori
                    </h6>
                </div>
                <canvas id="category-chart"></canvas>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <i class="fa fa-chart-line"></i>
                        Tren Peminjaman {{ date('Y') }}
                    </h6>
                </div>
                <canvas id="loan-chart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== RECENT TABLE ===== --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6 class="table-card-title">
                <i class="fa fa-clock"></i>
                Peminjaman Terakhir
            </h6>
            <a href="{{ route('peminjaman.index') }}" class="link-see-all">
                Lihat Semua <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPeminjamans as $item)
                    <tr>
                        <td>
                            <div style="font-size:.8rem; color:#94a3b8; line-height:1;">
                                {{ $item->created_at->format('d M') }}
                            </div>
                            <div style="font-weight:600; font-size:.875rem;">
                                {{ $item->created_at->format('Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px; height:34px; border-radius:10px; background: linear-gradient(135deg,#0ea5e9,#06b6d4); display:flex; align-items:center; justify-content:center; color:#fff; font-size:.75rem; font-weight:700; flex-shrink:0;">
                                    {{ strtoupper(substr($item->nama_peminjam, 0, 2)) }}
                                </div>
                                <span style="font-weight:600;">{{ $item->nama_peminjam }}</span>
                            </div>
                        </td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>
                            @php $st = strtolower($item->status); @endphp
                            <span class="status-badge {{ $st === 'dipinjam' ? 'dipinjam' : ($st === 'kembali' ? 'kembali' : 'pending') }}">
                                <i class="fa fa-circle" style="font-size:.45rem;"></i>
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.index') }}" class="btn-detail">
                                <i class="fa fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">
                            <div class="d-flex flex-column align-items-center gap-2" style="padding: 32px;">
                                <div style="width:56px; height:56px; background:#f0f9ff; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#0ea5e9; font-size:1.5rem;">
                                    <i class="fa fa-inbox"></i>
                                </div>
                                <span style="color:#94a3b8; font-size:.875rem;">Belum ada data peminjaman</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Category Chart (Bar)
    var ctx1 = $("#category-chart").get(0).getContext("2d");
    new Chart(ctx1, {
        type: "bar",
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                label: "Jumlah Barang",
                data: {!! json_encode($categoryData) !!},
                backgroundColor: [
                    "rgba(14,165,233,.75)",
                    "rgba(6,182,212,.75)",
                    "rgba(16,185,129,.75)",
                    "rgba(245,158,11,.75)",
                    "rgba(139,92,246,.75)",
                    "rgba(236,72,153,.75)"
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 10,
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false } },
                y: {
                    grid: { color: '#f1f5f9', borderDash: [4,4] },
                    border: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } }
                }
            }
        }
    });

    // Loan Chart (Line)
    var ctx2 = $("#loan-chart").get(0).getContext("2d");
    var gradient = ctx2.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(14,165,233,.35)");
    gradient.addColorStop(1, "rgba(14,165,233,0)");

    new Chart(ctx2, {
        type: "line",
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: "Peminjaman",
                data: {!! json_encode($monthData) !!},
                backgroundColor: gradient,
                borderColor: "#0ea5e9",
                borderWidth: 2.5,
                pointBackgroundColor: "#0ea5e9",
                pointBorderColor: "#fff",
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 10,
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                y: {
                    grid: { color: '#f1f5f9', borderDash: [4,4] },
                    border: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush
