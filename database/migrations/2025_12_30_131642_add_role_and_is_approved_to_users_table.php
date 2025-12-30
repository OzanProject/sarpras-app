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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('password');
            $table->boolean('is_approved')->default(false)->after('role');
        });

        // Approve all existing users (so admin doesn't get locked out)
        DB::table('users')->update(['is_approved' => true, 'role' => 'admin']); 
        // Logic: First existing user is usually admin. Let's make all current users admins/approved for safety in dev env.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('is_approved');
        });
    }
};
