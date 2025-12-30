@extends('layouts.admin')

@section('title', 'Riwayat Perbaikan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6>Riwayat Perbaikan Aset</h6>
                <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Lapor Kerusakan</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Kerusakan</th>
                            <th scope="col">Biaya</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $maintenance)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $maintenance->tgl_lapor->format('d M Y') }}</td>
                            <td>{{ $maintenance->barang->nama }} ({{ $maintenance->barang->kode_barang }})</td>
                            <td>{{ Str::limit($maintenance->deskripsi_kerusakan, 30) }}</td>
                            <td>Rp {{ number_format($maintenance->biaya ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($maintenance->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($maintenance->status == 'proses')
                                    <span class="badge bg-info text-dark">Proses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data perbaikan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data perbaikan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
