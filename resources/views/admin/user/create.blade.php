@extends('layouts.admin')

@section('content')
  <div class="row g-4">
    <div class="col-sm-12 col-xl-8">
      <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Tambah User Baru</h6>
        <form action="{{ route('user.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label for="role_id" class="form-label">Role (Hak Akses)</label>
            <select class="form-select" id="role_id" name="role_id" required>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                  {{ ucfirst($role->name) }}
                  @if($role->description) - {{ $role->description }} @endif
                </option>
              @endforeach
            </select>
            @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('user.index') }}" class="btn btn-outline-light">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection