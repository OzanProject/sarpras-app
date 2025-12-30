@extends('layouts.admin')

@section('title', 'Pilih Peminjaman untuk Dikembalikan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Pengembalian Barang: <span class="text-primary">{{ $barang->nama }}</span> ({{ $barang->kode_barang }})</h6>
            
            <div class="alert alert-info">
                Item ini sedang dipinjam oleh <strong>{{ $activeLoans->count() }}</strong> orang. Pilih transaksi yang ingin dikembalikan.
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">Tgl Pinjam</th>
                            <th scope="col">Nama Peminjam</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeLoans as $loan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') }}</td>
                            <td>{{ $loan->nama_peminjam }}</td>
                            <td>{{ $loan->jumlah }}</td>
                            <td>{{ $loan->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('peminjaman.return', $loan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan barang ini? Stok akan otomatis bertambah.');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fa fa-check-circle me-1"></i> Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="{{ route('scan.index') }}" class="btn btn-outline-light">Kembali ke Scan</a>
            </div>
        </div>
    </div>
</div>
@endsection
