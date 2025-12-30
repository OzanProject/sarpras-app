@extends('layouts.admin')

@section('title', 'Dashboard User')

@section('content')
<div class="row g-4">
    <!-- User Stats -->
    <div class="col-sm-6 col-xl-6">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-handshake fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Sedang Dipinjam</p>
                <h6 class="mb-0">{{ $activeLoans }} Barang</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-6">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-history fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Total Riwayat</p>
                <h6 class="mb-0">{{ $totalHistory }} Transaksi</h6>
            </div>
        </div>
    </div>

    <!-- Dynamic Loan QR -->
    <div class="col-sm-6 col-xl-4">
        <div class="bg-secondary rounded h-100 p-4 text-center">
            <h6 class="mb-3">QR Rekapan Aktif</h6>
            <div class="bg-white p-2 d-inline-block rounded">
                <!-- Limit summary length to avoid huge QRs -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(Str::limit($loanSummary, 900)) }}" alt="QR Summary" class="img-fluid">
            </div>
            <p class="text-xs text-muted mt-2 mb-0">Scan untuk lihat daftar barang</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-sm-6 col-xl-8">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Aksi Cepat</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('profile.download-qr') }}" class="btn btn-outline-primary py-3" target="_blank">
                    <i class="fa fa-id-card me-2"></i> Download Kartu Anggota (QR)
                </a>
                <a href="{{ route('user.scan.index') }}" class="btn btn-outline-success py-3">
                    <i class="fa fa-qrcode me-2"></i> Scan Barang untuk Pengembalian
                </a>
            </div>
        </div>
    </div>

    <!-- Active Loans Table -->
    <div class="col-sm-12 col-xl-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Barang Sedang Anda Pinjam</h6>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">Barang</th>
                            <th scope="col">Tgl Pinjam</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currentLoans as $loan)
                        <tr>
                            <td>{{ $loan->barang->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M') }}</td>
                            <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
                            <td>
                                <!-- Helper helper for testing: Show QR of this item -->
                                <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#qrModal{{ $loan->barang->id }}">
                                    <i class="fa fa-qrcode"></i> Lihat QR
                                </button>
                                
                                <!-- QR Modal -->
                                <div class="modal fade" id="qrModal{{ $loan->barang->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content bg-secondary text-center p-3">
                                            <h6 class="text-primary mb-2">QR {{ $loan->barang->nama }}</h6>
                                            <div class="bg-white p-2 d-inline-block rounded mx-auto mb-2">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $loan->barang->id }}" alt="QR" class="img-fluid">
                                            </div>
                                            <p class="mb-0 text-white small">ID: {{ $loan->barang->id }} / Code: {{ $loan->barang->kode_barang }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada barang yang sedang dipinjam.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-end">
                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-sm btn-primary">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
</div>
@endsection
