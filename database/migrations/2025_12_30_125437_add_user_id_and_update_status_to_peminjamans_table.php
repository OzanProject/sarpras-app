<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('barang_id')->constrained()->nullOnDelete();
        });

        // Modify the enum column to include new statuses
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('pending', 'dipinjam', 'kembali', 'ditolak') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Revert enum (Note: this might fail if there are records with new statuses, but it's okay for dev rollback)
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('dipinjam', 'kembali') NOT NULL DEFAULT 'dipinjam'");
    }
};
