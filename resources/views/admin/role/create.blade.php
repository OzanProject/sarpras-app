@extends('layouts.admin')

@section('title', 'Tambah Hak Akses')

@section('content')
<div class="container-fluid pt-4 px-4">
  <form action="{{ route('role.store') }}" method="POST">
    @csrf

    <div class="row g-4">
      <!-- Kolom Kiri: Informasi Role & Aksi -->
      <div class="col-lg-5 col-xl-4">
        <div class="bg-secondary rounded p-4 h-100 shadow-sm border border-light">
          <h6 class="mb-4 d-flex align-items-center">
            <span class="d-flex align-items-center justify-content-center bg-primary-light rounded p-2 me-2" style="width: 38px; height: 38px; background: rgba(14, 165, 233, 0.1);">
              <i class="fa fa-user-shield text-primary"></i>
            </span>
            <span>Informasi Role</span>
          </h6>

          <div class="mb-3">
            <label for="name" class="form-label text-dark">Nama Role</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}"
              placeholder="Contoh: Staff TU, Teknisi">
            @error('name') 
              <div class="text-danger mt-1 small"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div> 
            @enderror
          </div>

          <div class="mb-4">
            <label for="description" class="form-label text-dark">Keterangan / Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="4"
              placeholder="Deskripsi singkat tentang tanggung jawab atau fungsi hak akses ini...">{{ old('description') }}</textarea>
            @error('description') 
              <div class="text-danger mt-1 small"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div> 
            @enderror
          </div>

          <hr class="my-4 text-muted opacity-25">

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary w-100 py-2.5">
              <i class="fa fa-save me-2"></i>Simpan Role Baru
            </button>
            <a href="{{ route('role.index') }}" class="btn btn-outline-secondary w-100 py-2.5">
              <i class="fa fa-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Detail Hak Akses (Permissions) -->
      <div class="col-lg-7 col-xl-8">
        <div class="bg-secondary rounded p-4 h-100 shadow-sm border border-light">
          <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <h6 class="mb-0 m-0 border-0 p-0 d-flex align-items-center">
              <span class="d-flex align-items-center justify-content-center bg-primary-light rounded p-2 me-2" style="width: 38px; height: 38px; background: rgba(14, 165, 233, 0.1);">
                <i class="fa fa-key text-primary"></i>
              </span>
              <span>Detail Hak Akses (Permissions)</span>
            </h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="toggle-all-perms">
              Pilih Semua
            </button>
          </div>

          <p class="text-muted small mb-4">
            Aktifkan izin akses di bawah ini sesuai dengan tugas dan tanggung jawab role baru Anda.
          </p>

          <div class="permissions-container" style="max-height: 500px; overflow-y: auto; padding-right: 8px;">
            @foreach($permissions as $group => $perms)
              <div class="card bg-light mb-4 border-light shadow-sm">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center py-3 px-3">
                  <h6 class="mb-0 text-primary h6" style="font-size: 0.95rem !important; border: 0 !important; margin: 0 !important; padding: 0 !important; font-weight: 700;">
                    <i class="fa fa-folder-open me-2 text-primary opacity-75"></i>{{ $group }}
                  </h6>
                  <div class="form-check form-switch m-0">
                    <input class="form-check-input group-select-all" type="checkbox" data-group="{{ Str::slug($group) }}" id="select_all_{{ Str::slug($group) }}">
                    <label class="form-check-label text-muted small cursor-pointer" for="select_all_{{ Str::slug($group) }}">Pilih Semua</label>
                  </div>
                </div>
                <div class="card-body py-3 px-3">
                  <div class="row">
                    @foreach($perms as $perm)
                      <div class="col-md-6 col-xxl-4 mb-2">
                        <div class="form-check form-switch">
                          <input class="form-check-input perm-checkbox {{ Str::slug($group) }}-checkbox" type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                            id="perm_{{ $perm->id }}">
                          <label class="form-check-label small cursor-pointer" for="perm_{{ $perm->id }}">
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
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select/Deselect All Permissions
    const toggleAllBtn = document.getElementById('toggle-all-perms');
    const allCheckboxes = document.querySelectorAll('.perm-checkbox');
    const groupSelectAlls = document.querySelectorAll('.group-select-all');

    if (toggleAllBtn) {
        let isAllChecked = Array.from(allCheckboxes).every(cb => cb.checked);
        updateToggleAllButton(isAllChecked);

        toggleAllBtn.addEventListener('click', function() {
            isAllChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            const targetState = !isAllChecked;

            allCheckboxes.forEach(cb => cb.checked = targetState);
            groupSelectAlls.forEach(cb => cb.checked = targetState);
            updateToggleAllButton(targetState);
        });
    }

    function updateToggleAllButton(checked) {
        if (checked) {
            toggleAllBtn.textContent = 'Batal Pilih Semua';
            toggleAllBtn.classList.replace('btn-outline-primary', 'btn-primary');
        } else {
            toggleAllBtn.textContent = 'Pilih Semua';
            toggleAllBtn.classList.replace('btn-primary', 'btn-outline-primary');
        }
    }

    // Group Select All logic
    groupSelectAlls.forEach(groupCb => {
        const groupSlug = groupCb.dataset.group;
        const memberCheckboxes = document.querySelectorAll(`.${groupSlug}-checkbox`);

        // Initial check for each group select all status
        const allGroupChecked = Array.from(memberCheckboxes).every(cb => cb.checked);
        groupCb.checked = allGroupChecked;

        groupCb.addEventListener('change', function() {
            memberCheckboxes.forEach(cb => cb.checked = this.checked);
            checkOverallStatus();
        });

        memberCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allGroupChecked = Array.from(memberCheckboxes).every(c => c.checked);
                groupCb.checked = allGroupChecked;
                checkOverallStatus();
            });
        });
    });

    function checkOverallStatus() {
        if (toggleAllBtn) {
            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            updateToggleAllButton(allChecked);
        }
    }
});
</script>
<style>
.cursor-pointer {
    cursor: pointer;
}
.permissions-container::-webkit-scrollbar {
    width: 6px;
}
.permissions-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}
.permissions-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.permissions-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush