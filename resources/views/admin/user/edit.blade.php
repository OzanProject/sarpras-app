@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Edit Pengguna: {{ $user->name }}</h6>
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-select" id="role_id" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Approval</label>
                        <input type="text" class="form-control" value="{{ $user->is_approved ? 'Disetujui' : 'Menunggu' }}"
                            disabled>
                        @if(!$user->is_approved)
                            <div class="form-text text-warning">Untuk menyetujui, gunakan tombol Approve di halaman index.</div>
                        @endif
                    </div>

                    <hr>
                    <h6 class="mb-3">Reset Password (Opsional)</h6>
                    <div class="alert alert-info py-2">Kosongkan jika tidak ingin mengganti password user ini.</div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Biarkan kosong jika tetap">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('user.index') }}" class="btn btn-dark">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection