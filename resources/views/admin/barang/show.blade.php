@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-12">
        <div class="bg-secondary rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Detail Barang: {{ $barang->nama }}</h6>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-light btn-sm"><i class="fa fa-arrow-left me-2"></i>Kembali</a>
            </div>
            
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" class="img-fluid rounded mb-3" alt="Foto Barang">
                    @else
                        <div class="bg-dark rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                            <span class="text-muted">Tidak ada foto</span>
                        </div>
                    @endif

                    <div class="card bg-dark border-secondary">
                        <div class="card-body text-center">
                            <h6 class="text-white mb-2">QR Code</h6>
                            <!-- Public QR Code API for simplicity -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $barang->kode_barang }}" alt="QR Code" class="img-fluid bg-white p-2 rounded">
                            <div class="mt-2">
                                <small class="text-muted">{{ $barang->kode_barang }}</small>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <form action="{{ route('barang.print') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="ids[]" value="{{ $barang->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fa fa-file-pdf me-2"></i>Cetak Label / PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered border-white">
                            <tr>
                                <th class="w-25">Kode Barang</th>
                                <td>{{ $barang->kode_barang }}</td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $barang->nama }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $barang->kategori->nama }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $barang->stok }} Unit</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>
                                    <span class="badge {{ $barang->kondisi == 'baik' ? 'bg-success' : ($barang->kondisi == 'rusak' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($barang->kondisi) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Lokasi / Ruangan</th>
                                <td>{{ $barang->room->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Update</th>
                                <td>{{ $barang->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function downloadQR(url, filename) {
        fetch(url)
            .then(response => response.blob())
            .then(blob => {
                const blobUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(blobUrl);
                document.body.removeChild(a);
            })
            .catch(() => alert('Gagal mendownload gambar. Coba lagi.'));
    }
</script>
@endpush
