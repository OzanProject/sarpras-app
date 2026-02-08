@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Manajemen User</h6>
                        <a href="{{ route('user.create') }}" class="btn btn-sm btn-success"><i
                                class="fa fa-plus me-2"></i>Tambah User</a>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal Daftar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role->name ?? 'User') }}</td>
                                        <td>
                                            @if($user->is_approved)
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(!$user->is_approved)
                                                    <form action="{{ route('user.approve', $user->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Setujui user ini agar bisa login?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" title="Approve"><i
                                                                class="fa fa-check"></i></button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-info ms-1"
                                                    title="Edit"><i class="fa fa-edit"></i></a>

                                                @if($user->id != auth()->id())
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Hapus user ini? Data peminjaman juga mungkin terhapus (cascade) atau tersimpan tanpa user.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger ms-1" title="Hapus"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada user terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection