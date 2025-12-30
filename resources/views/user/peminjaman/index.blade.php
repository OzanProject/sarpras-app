@extends('layouts.admin')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Riwayat Peminjaman Saya</h6>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $peminjaman)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $peminjaman->barang->nama }} ({{ $peminjaman->barang->kode_barang }})</td>
                            <td>{{ $peminjaman->tgl_pinjam->format('d M Y') }}</td>
                            <td>
                                @if($peminjaman->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                @elseif($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-primary">Sedang Dipinjam</span>
                                @elseif($peminjaman->status == 'kembali')
                                    <span class="badge bg-success">Dikembalikan: {{ $peminjaman->tgl_kembali ? $peminjaman->tgl_kembali->format('d M') : '-' }}</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $peminjaman->keterangan ?? '-' }}</td>
                            <td>
                                <!-- QR Helper for Active Loans -->
                                @if($peminjaman->status == 'dipinjam')
                                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#qrModalHist{{ $peminjaman->id }}">
                                        <i class="fa fa-qrcode"></i> Lihat QR
                                    </button>
                                    
                                    <!-- QR Modal -->
                                    <div class="modal fade" id="qrModalHist{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content bg-secondary text-center p-3">
                                                <h6 class="text-primary mb-2">QR {{ $peminjaman->barang->nama }}</h6>
                                                <div class="bg-white p-2 d-inline-block rounded mx-auto mb-2">
                                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $peminjaman->barang->id }}" alt="QR" class="img-fluid">
                                                </div>
                                                <p class="mb-0 text-white small">ID: {{ $peminjaman->barang->id }} / Code: {{ $peminjaman->barang->kode_barang }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <a href="{{ url('/') }}" class="btn btn-outline-light">Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</div>
@endsection
