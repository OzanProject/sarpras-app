@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Filter Laporan</h6>
            
            <form action="{{ route('report.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="kembali" {{ $status == 'kembali' ? 'selected' : '' }}>Kembali</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2"><i class="fa fa-filter me-2"></i>Filter</button>
                        <a href="{{ route('report.print', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" target="_blank" class="btn btn-success w-100"><i class="fa fa-print me-2"></i>Cetak</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">No</th>
                            <th scope="col">Tgl Pinjam</th>
                            <th scope="col">Peminjam</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tgl Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td colspan="7" class="text-center">Tidak ada data pada periode ini using.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
