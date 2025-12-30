@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        <!-- Profile Information -->
        <div class="bg-secondary rounded p-4 mb-4">
            <h6 class="mb-4">Informasi Profil</h6>
            
            @if(session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>Profil berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control bg-dark" id="photo" name="photo">
                    @if($user->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    @endif
                    @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-secondary rounded p-4">
            <h6 class="mb-4">Ganti Password</h6>
            
            @if(session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>Password berhasil diubah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">
                    @error('current_password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-warning"><i class="fa fa-key me-2"></i>Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
