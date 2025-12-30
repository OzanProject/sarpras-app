@extends('layouts.admin')

@section('title', 'Edit Ruangan')

@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-6">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Form Edit Ruangan</h6>
            <form action="{{ route('room.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ruangan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $room->nama) }}" required>
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $room->keterangan) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Update</button>
                <a href="{{ route('room.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
