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
    Schema::table('users', function (Blueprint $table) {
      $table->unsignedBigInteger('role_id')->nullable()->after('password');
    });

    // Migrate existing role enum data to role_id
    $adminRole = DB::table('roles')->where('name', 'admin')->first();
    $userRole = DB::table('roles')->where('name', 'user')->first();

    if ($adminRole) {
      DB::table('users')->where('role', 'admin')->update(['role_id' => $adminRole->id]);
    }
    if ($userRole) {
      DB::table('users')->where('role', 'user')->update(['role_id' => $userRole->id]);
      // Default null roles to user
      DB::table('users')->whereNull('role')->update(['role_id' => $userRole->id]);
    }

    // Make role_id required (after data migration)
    Schema::table('users', function (Blueprint $table) {
      $table->unsignedBigInteger('role_id')->nullable(false)->change();
      $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');

      // Drop old enum column
      $table->dropColumn('role');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('role', ['admin', 'user'])->default('user')->after('password');
      $table->dropForeign(['role_id']);
      $table->dropColumn('role_id');
    });
  }
};
