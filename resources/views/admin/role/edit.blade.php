@extends('layouts.admin')

@section('content')
  <div class="row g-4 justify-content-center">
    <div class="col-sm-12 col-xl-6">
      <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Edit Hak Akses (Role)</h6>
        <form action="{{ route('role.update', $role->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name" class="form-label">Nama Role</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $role->name) }}"
              placeholder="Contoh: Staff TU">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Keterangan</label>
            <textarea class="form-control" id="description" name="description" rows="3"
              placeholder="Deskripsi singkat tentang hak akses ini...">{{ old('description', $role->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label d-block mb-3">Detail Hak Akses (Permissions)</label>

            @foreach($permissions as $group => $perms)
              <div class="card bg-dark mb-3 border-secondary">
                <div class="card-header border-secondary">
                  <h6 class="mb-0 text-primary">{{ $group }}</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    @foreach($perms as $perm)
                      <div class="col-md-6 col-lg-4 mb-2">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                            id="perm_{{ $perm->id }}" {{ $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                          <label class="form-check-label" for="perm_{{ $perm->id }}">
                            {{ $perm->label }}
                          </label>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('role.index') }}" class="btn btn-outline-light">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection