@extends('layouts.admin')

@section('title', 'Lapor Kerusakan')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Form Lapor Kerusakan Barang</h6>
            <form action="{{ route('maintenance.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <label for="barang_id" class="col-sm-2 col-form-label">Barang</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="barang_id" name="barang_id" required>
                            <option value="">Pilih Barang yang Rusak</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama }} - {{ $barang->kode_barang }}
                                    ({{ ucfirst($barang->kondisi) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tgl_lapor" class="col-sm-2 col-form-label">Tanggal Lapor</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_lapor" name="tgl_lapor" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="deskripsi_kerusakan" class="col-sm-2 col-form-label">Deskripsi Kerusakan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" required>{{ old('deskripsi_kerusakan') }}</textarea>
                        <div class="form-text text-muted">Jelaskan detail kerusakan yang terjadi.</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Status Awal</label>
                    <div class="col-sm-10">
                         <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending (Menunggu Perbaikan)</option>
                            <option value="proses">Proses (Sedang Diperbaiki)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Simpan Laporan</button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
