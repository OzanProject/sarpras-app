@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Barang</h6>
                <div>
                    <button type="button" class="btn btn-warning btn-sm me-2" onclick="validateSelection()"><i class="fa fa-print me-2"></i>Cetak QR Terpilih</button>
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Tambah Barang</a>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Hidden Form for Bulk Print -->
            <form id="bulk-print-form" action="{{ route('barang.print') }}" method="POST" target="_blank" class="d-none">
                @csrf
                <div id="bulk-inputs"></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="40">
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $barang->id }}" class="form-check-input item-checkbox">
                            </td>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->kategori->nama }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>
                                <span class="badge {{ $barang->kondisi == 'baik' ? 'bg-success' : ($barang->kondisi == 'rusak' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($barang->kondisi) }}
                                </span>
                            </td>
                            <td>{{ $barang->room->nama ?? '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-info" title="Detail & QR"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data barang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        
        // Select All Logic
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }

        // Individual Checkbox Logic (Update Select All state)
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked) {
                    if(selectAll) selectAll.checked = false;
                } else {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    if (allChecked && selectAll) selectAll.checked = true;
                }
            });
        });
    });

    function validateSelection() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu barang untuk dicetak.');
            return false;
        }

        const form = document.getElementById('bulk-print-form');
        const container = document.getElementById('bulk-inputs');
        container.innerHTML = ''; // Clear previous

        checkboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });
        
        form.submit();
        return false; // Prevent default button action if it was submit
    }
</script>
@endpush
@endsection
