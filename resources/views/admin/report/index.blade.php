@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <ul class="nav nav-pills mb-4 pb-2 border-bottom" id="reportTabs">
                <li class="nav-item me-2">
                    <a class="nav-link {{ $type == 'peminjaman' ? 'active bg-primary text-white' : 'bg-light text-dark' }} px-4 py-2 fw-semibold rounded-pill" 
                       href="{{ route('report.index', ['type' => 'peminjaman', 'start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}">
                        <i class="fa fa-handshake me-2"></i>Laporan Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'aset' ? 'active bg-primary text-white' : 'bg-light text-dark' }} px-4 py-2 fw-semibold rounded-pill" 
                       href="{{ route('report.index', ['type' => 'aset', 'start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}">
                        <i class="fa fa-boxes me-2"></i>Laporan Total Aset/Barang
                    </a>
                </li>
            </ul>

            <style>
                #reportTabs .nav-link:not(.active):hover {
                    background-color: #e9ecef !important;
                    color: #0ea5e9 !important;
                }
            </style>

            <h6 class="mb-4">Filter Laporan</h6>
            
            <form action="{{ route('report.index') }}" method="GET" class="mb-4">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="row g-3">
                    @if($type == 'peminjaman')
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    @endif
                    <div class="col-md-3">
                        <label class="form-label">Status {{ $type == 'aset' ? 'Kondisi' : '' }}</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @if($type == 'peminjaman')
                                <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="kembali" {{ $status == 'kembali' ? 'selected' : '' }}>Kembali</option>
                            @else
                                <option value="baik" {{ $status == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ $status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ $status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2"><i class="fa fa-filter me-2"></i>Filter</button>
                        <a href="{{ route('report.print', ['type' => $type, 'start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" target="_blank" class="btn btn-success w-100"><i class="fa fa-print me-2"></i>Cetak</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">No</th>
                            @if($type == 'peminjaman')
                                <th scope="col">Tgl Pinjam</th>
                                <th scope="col">Peminjam</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tgl Kembali</th>
                            @else
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Lokasi / Ruang</th>
                                <th scope="col">PJ Ruangan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($type == 'peminjaman')
                            @forelse($peminjamans as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->translatedFormat('d M Y') }}</td>
                                <td>{{ $item->nama_peminjam }}</td>
                                <td>{{ $item->barang->nama ?? '-' }} ({{ $item->barang->kode_barang ?? '-' }})</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'dipinjam' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->translatedFormat('d M Y') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data peminjaman pada periode ini.</td>
                            </tr>
                            @endforelse
                        @else
                            @forelse($barangs as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $barang->kode_barang }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->kategori->nama ?? '-' }}</td>
                                <td>{{ $barang->stok }}</td>
                                <td>
                                    <span class="badge {{ $barang->kondisi == 'baik' ? 'bg-success' : ($barang->kondisi == 'rusak' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($barang->kondisi) }}
                                    </span>
                                </td>
                                <td>{{ $barang->room->nama ?? '-' }}</td>
                                <td>{{ $barang->room->pj_ruangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data barang.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
