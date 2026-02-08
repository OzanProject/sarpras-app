<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use Illuminate\Support\Facades\Route;

// Auth routes handled by Breeze

// Temporary Debug Route (Remove after fixing login)
Route::get('/debug-sarpas', function () {
    $driver = config('session.driver');
    $path = storage_path('framework/sessions');
    $isWritable = is_writable($path);

    session(['test_session' => 'Session Working']);
    $sessionVal = session('test_session');

    $adminExists = \App\Models\User::where('email', 'admin@admin.com')->exists();
    $userCount = \App\Models\User::count();

    return response()->json([
        'session_driver' => $driver,
        'storage_path' => $path,
        'is_writable' => $isWritable,
        'session_test_value' => $sessionVal,
        'env_app_url' => env('APP_URL'),
        'https_status' => request()->secure(),
        'database_check' => [
            'admin_email_exists' => $adminExists,
            'total_users' => $userCount,
        ]
    ]);
});

require __DIR__ . '/auth.php';

Route::get('/', [\App\Http\Controllers\PublicController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Allow email verification without approval check (optional, but safer to block everything)
    // For now blocking everything except logout/verify

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Protect all other auth routes with 'approved' middleware
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Self-Service
    Route::post('/peminjaman/request', [\App\Http\Controllers\UserPeminjamanController::class, 'store'])->name('user.peminjaman.store');
    Route::get('/my-loans', [\App\Http\Controllers\UserPeminjamanController::class, 'index'])->name('user.peminjaman.index');
});

Route::middleware(['auth', 'approved'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard'); // Moved out

    Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->except(['show']);
    Route::resource('room', \App\Http\Controllers\RoomController::class);
    // Barang Routes
    Route::post('/barang/print', [\App\Http\Controllers\BarangController::class, 'print'])->name('barang.print');
    Route::resource('barang', \App\Http\Controllers\BarangController::class);

    // Peminjaman Routes
    Route::get('/peminjaman/active-loans/{barang_id}', [\App\Http\Controllers\PeminjamanController::class, 'activeLoans'])->name('peminjaman.active-loans');
    Route::post('/peminjaman/{id}/return', [\App\Http\Controllers\PeminjamanController::class, 'returnItem'])->name('peminjaman.return');
    Route::post('/peminjaman/{id}/approve', [\App\Http\Controllers\PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [\App\Http\Controllers\PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::resource('peminjaman', \App\Http\Controllers\PeminjamanController::class);
    Route::resource('maintenance', \App\Http\Controllers\MaintenanceController::class);

    // Report Routes
    Route::get('/report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('report.print');

    // Scan Routes
    Route::get('/scan', [\App\Http\Controllers\ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan', [\App\Http\Controllers\ScanController::class, 'process'])->name('scan.process');

    // Setting Routes
    Route::get('/setting', [\App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [\App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

    // User Features
    Route::get('/profile/download-qr', [\App\Http\Controllers\ProfileController::class, 'downloadQr'])->name('profile.download-qr');
    Route::get('/user/scan', [\App\Http\Controllers\UserScanController::class, 'index'])->name('user.scan.index');
    Route::post('/user/scan', [\App\Http\Controllers\UserScanController::class, 'process'])->name('user.scan.process');

    // User Management (Admin Only)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::post('/users/{id}/approve', [\App\Http\Controllers\UserController::class, 'approve'])->name('user.approve');
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});
