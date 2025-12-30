@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Sale & Revenue Start -->
<div class="row pt-4 px-4">
    <div class="col-12 mb-4">
        <div class="bg-secondary rounded p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-0 text-primary">Sarana Prasarana</h3>
                    <h6 class="mb-0 text-white">{{ $global_settings['nama_sekolah'] ?? 'Sekolah' }}</h6>
                </div>
                <div class="text-end">
                    <p class="mb-0 text-muted">Tanggal: {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row px-4">
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-box fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Total Barang</p>
                <h6 class="mb-0">{{ $totalBarang }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-th-list fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Total Kategori</p>
                <h6 class="mb-0">{{ $totalKategori }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-handshake fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Dipinjam</p>
                <h6 class="mb-0">{{ $dipinjam }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-tools fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Barang Rusak</p>
                <h6 class="mb-0">{{ $rusak }}</h6>
            </div>
        </div>
    </div>
</div>

<!-- Charts Start -->
<div class="row px-4 mb-4">
    <div class="col-sm-12 col-xl-6">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Stok Barang per Kategori</h6>
            <canvas id="category-chart"></canvas>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Tren Peminjaman ({{ date('Y') }})</h6>
            <canvas id="loan-chart"></canvas>
        </div>
    </div>
</div>
<!-- Charts End -->

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Peminjaman Terakhir</h6>
            <a href="{{ route('peminjaman.index') }}">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Tanggal</th>
                        <th scope="col">Peminjam</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPeminjamans as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>{{ $item->nama_peminjam }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'dipinjam' ? 'bg-warning' : 'bg-success' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td><a class="btn btn-sm btn-primary" href="{{ route('peminjaman.index') }}">Detail</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->
@endsection

@push('scripts')
<script>
    // Category Chart (Bar)
    var ctx1 = $("#category-chart").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                label: "Jumlah Barang",
                data: {!! json_encode($categoryData) !!},
                backgroundColor: "rgba(235, 22, 22, .7)",
                fill: true
            }]
        },
        options: {
            responsive: true
        }
    });

    // Loan Chart (Line)
    var ctx2 = $("#loan-chart").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: "Frekuensi Peminjaman",
                data: {!! json_encode($monthData) !!},
                backgroundColor: "rgba(235, 22, 22, .5)",
                borderColor: "rgba(235, 22, 22, 1)",
                fill: true
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endpush
