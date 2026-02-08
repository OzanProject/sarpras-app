<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('permissions', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique(); // e.g. 'barang.create'
      $table->string('label'); // e.g. 'Tambah Barang'
      $table->string('group'); // e.g. 'Manajemen Barang'
      $table->timestamps();
    });

    Schema::create('permission_role', function (Blueprint $table) {
      $table->id();
      $table->foreignId('role_id')->constrained()->onDelete('cascade');
      $table->foreignId('permission_id')->constrained()->onDelete('cascade');
      $table->timestamps();
    });

    // Seed Default Permissions
    $permissions = [
      // Dashboard
      ['name' => 'dashboard.view_admin', 'label' => 'Lihat Dashboard Admin', 'group' => 'Dashboard'],

      // Kategori
      ['name' => 'kategori.view', 'label' => 'Lihat Kategori', 'group' => 'Kategori'],
      ['name' => 'kategori.create', 'label' => 'Tambah Kategori', 'group' => 'Kategori'],
      ['name' => 'kategori.edit', 'label' => 'Edit Kategori', 'group' => 'Kategori'],
      ['name' => 'kategori.delete', 'label' => 'Hapus Kategori', 'group' => 'Kategori'],

      // Room (Ruangan)
      ['name' => 'room.view', 'label' => 'Lihat Ruangan', 'group' => 'Ruangan'],
      ['name' => 'room.create', 'label' => 'Tambah Ruangan', 'group' => 'Ruangan'],
      ['name' => 'room.edit', 'label' => 'Edit Ruangan', 'group' => 'Ruangan'],
      ['name' => 'room.delete', 'label' => 'Hapus Ruangan', 'group' => 'Ruangan'],

      // Barang
      ['name' => 'barang.view', 'label' => 'Lihat Barang', 'group' => 'Barang'],
      ['name' => 'barang.create', 'label' => 'Tambah Barang', 'group' => 'Barang'],
      ['name' => 'barang.edit', 'label' => 'Edit Barang', 'group' => 'Barang'],
      ['name' => 'barang.delete', 'label' => 'Hapus Barang', 'group' => 'Barang'],
      ['name' => 'barang.print', 'label' => 'Cetak QR Barang', 'group' => 'Barang'],

      // Peminjaman
      ['name' => 'peminjaman.view', 'label' => 'Lihat Peminjaman', 'group' => 'Peminjaman'],
      ['name' => 'peminjaman.action', 'label' => 'Proses Peminjaman (Approve/Reject)', 'group' => 'Peminjaman'],

      // Scan QR
      ['name' => 'scan.view', 'label' => 'Akses Scan QR', 'group' => 'Scan QR'],

      // Perbaikan / Maintenance
      ['name' => 'maintenance.view', 'label' => 'Lihat Perbaikan', 'group' => 'Perbaikan'],
      ['name' => 'maintenance.create', 'label' => 'Tambah Perbaikan', 'group' => 'Perbaikan'],
      ['name' => 'maintenance.edit', 'label' => 'Edit Perbaikan', 'group' => 'Perbaikan'],
      ['name' => 'maintenance.delete', 'label' => 'Hapus Perbaikan', 'group' => 'Perbaikan'],

      // Laporan
      ['name' => 'report.view', 'label' => 'Akses Laporan', 'group' => 'Laporan'],

      // Settings
      ['name' => 'setting.view', 'label' => 'Akses Pengaturan Umum', 'group' => 'Pengaturan'],

      // User Management
      ['name' => 'user.view', 'label' => 'Lihat User', 'group' => 'Manajemen User'],
      ['name' => 'user.create', 'label' => 'Tambah User', 'group' => 'Manajemen User'],
      ['name' => 'user.edit', 'label' => 'Edit User', 'group' => 'Manajemen User'],
      ['name' => 'user.delete', 'label' => 'Hapus User', 'group' => 'Manajemen User'],

      // Role Management
      ['name' => 'role.view', 'label' => 'Lihat Role', 'group' => 'Manajemen Hak Akses'],
      ['name' => 'role.create', 'label' => 'Tambah Role', 'group' => 'Manajemen Hak Akses'],
      ['name' => 'role.edit', 'label' => 'Edit Role', 'group' => 'Manajemen Hak Akses'],
      ['name' => 'role.delete', 'label' => 'Hapus Role', 'group' => 'Manajemen Hak Akses'],
    ];

    DB::table('permissions')->insert(array_map(function ($p) {
      $p['created_at'] = now();
      $p['updated_at'] = now();
      return $p;
    }, $permissions));

    // Assign ALL permissions to Admin role
    $adminRole = DB::table('roles')->where('name', 'admin')->first();
    if ($adminRole) {
      $allPermissions = DB::table('permissions')->pluck('id');
      foreach ($allPermissions as $permId) {
        DB::table('permission_role')->insert([
          'role_id' => $adminRole->id,
          'permission_id' => $permId,
        ]);
      }
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permission_role');
    Schema::dropIfExists('permissions');
  }
};
