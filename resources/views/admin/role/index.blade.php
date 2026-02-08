@extends('layouts.admin')

@section('content')
  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">Manajemen Hak Akses (Role)</h6>
            <a href="{{ route('role.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus me-2"></i>Tambah
              Role</a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
              <thead>
                <tr class="text-white">
                  <th scope="col">#</th>
                  <th scope="col">Nama Role</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col">Jumlah User</th>
                  <th scope="col">Izin Akses</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($roles as $role)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucfirst($role->name) }}</td>
                    <td>{{ $role->description }}</td>
                    <td><span class="badge bg-primary">{{ $role->users_count }} User</span></td>
                    <td><span class="badge bg-secondary">{{ $role->permissions_count ?? $role->permissions()->count() }}
                        Izin</span></td>
                    <td>
                      <div class="d-flex gap-2">
                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @if($role->users_count == 0)
                          <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                          </form>
                        @else
                          <button class="btn btn-sm btn-secondary" disabled title="Masih digunakan">Hapus</button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">Belum ada data role.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection