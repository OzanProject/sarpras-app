@extends('layouts.admin')

@section('title', 'Pengaturan Umum')

@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Pengaturan Aplikasi</h6>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_sekolah" class="form-label">Nama Sekolah / Aplikasi</label>
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $settings['nama_sekolah'] ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ $settings['alamat'] ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $settings['email'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $settings['telepon'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo Instansi</label>
                    <input type="file" class="form-control bg-dark" id="logo" name="logo">
                    @if(isset($settings['logo']) && $settings['logo'])
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" height="80" class="bg-white rounded p-1">
                            <small class="d-block text-muted mt-1">Logo Saat Ini</small>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="footer_text" class="form-label">Teks Footer</label>
                    <input type="text" class="form-control" id="footer_text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
