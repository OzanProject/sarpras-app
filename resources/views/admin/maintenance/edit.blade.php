@extends('layouts.admin')

@php
    /** @var \App\Models\Maintenance $maintenance */
    /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Barang> $barangs */
@endphp

@section('title', 'Edit Perbaikan')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Update Data Perbaikan</h6>
            <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <label for="barang_id" class="col-sm-2 col-form-label">Barang</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="barang_id" value="{{ $maintenance->barang_id }}">
                        <input type="text" class="form-control" value="{{ $maintenance->barang->nama }} - {{ $maintenance->barang->kode_barang }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tgl_lapor" class="col-sm-2 col-form-label">Tanggal Lapor</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_lapor" name="tgl_lapor" value="{{ $maintenance->tgl_lapor->format('Y-m-d') }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="deskripsi_kerusakan" class="col-sm-2 col-form-label">Deskripsi Kerusakan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" required>{{ $maintenance->deskripsi_kerusakan }}</textarea>
                    </div>
                </div>

                <hr class="dropdown-divider bg-light my-4">

                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Status Perbaikan</label>
                    <div class="col-sm-10">
                         <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $maintenance->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $maintenance->status == 'proses' ? 'selected' : '' }}>Proses Perbaikan</option>
                            <option value="selesai" {{ $maintenance->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <div class="form-text text-warning" id="status-help">
                            *Jika status diubah menjadi SELESAI, stok barang akan dianggap BAIK kembali.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="biaya" class="col-sm-2 col-form-label">Biaya Perbaikan (Rp)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="biaya" name="biaya" min="0" value="{{ $maintenance->biaya }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tgl_selesai" class="col-sm-2 col-form-label">Tanggal Selesai</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{ $maintenance->tgl_selesai ? $maintenance->tgl_selesai->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
