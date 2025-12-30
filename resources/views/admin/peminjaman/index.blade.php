@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Peminjaman</h6>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Catat Peminjaman</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tgl Pinjam</th>
                            <th scope="col">Peminjam</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Jml</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tgl Kembali</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $pinjam)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $pinjam->tgl_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $pinjam->nama_peminjam }}</td>
                            <td>{{ $pinjam->barang->nama }}</td>
                            <td>{{ $pinjam->jumlah }}</td>
                                @if($pinjam->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($pinjam->status == 'dipinjam')
                                    <span class="badge bg-primary">Dipinjam</span>
                                @elseif($pinjam->status == 'kembali')
                                    <span class="badge bg-success">Kembali</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $pinjam->tgl_kembali ? $pinjam->tgl_kembali->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($pinjam->status == 'pending')
                                        <form action="{{ route('peminjaman.approve', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui peminjaman ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Setujui"><i class="fa fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('peminjaman.reject', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak peminjaman ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Tolak"><i class="fa fa-times"></i></button>
                                        </form>
                                    @elseif($pinjam->status == 'dipinjam')
                                        <form action="{{ route('peminjaman.return', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan barang ini? Stok akan otomatis bertambah.')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info" title="Kembalikan Barang"><i class="fa fa-undo"></i></button>
                                        </form>
                                    @endif
                                    <a href="{{ route('peminjaman.edit', $pinjam->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
