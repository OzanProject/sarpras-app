@extends('layouts.admin')

@section('title', 'Update Peminjaman')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-8">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Form Pengembalian / Edit Peminjaman</h6>
            
            <div class="alert alert-info">
                <strong>Info:</strong> Barang: {{ $peminjaman->barang->nama }} | Peminjam: {{ $peminjaman->nama_peminjam }}
            </div>

            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Masih Dipinjam</option>
                        <option value="kembali" {{ $peminjaman->status == 'kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                    </select>
                </div>

                <div class="mb-3" id="tgl_kembali_group">
                    <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="{{ $peminjaman->tgl_kembali ? $peminjaman->tgl_kembali->format('Y-m-d') : date('Y-m-d') }}">
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $peminjaman->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        function toggleTanggal() {
            if($('#status').val() == 'kembali') {
                $('#tgl_kembali_group').show();
            } else {
                $('#tgl_kembali_group').hide();
            }
        }
        toggleTanggal();
        $('#status').change(toggleTanggal);
    });
</script>
@endpush
@endsection
