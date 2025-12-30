@extends('layouts.admin')

@section('title', 'Catat Peminjaman')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-8">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Form Peminjaman Barang</h6>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Pilih Barang</label>
                    <select class="form-select" id="barang_id" name="barang_id" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}">
                                {{ $barang->kode_barang }} - {{ $barang->nama }} (Stok: {{ $barang->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" placeholder="Nama Siswa/Guru" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jumlah" class="form-label">Jumlah Pinjam</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan / Keperluan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
