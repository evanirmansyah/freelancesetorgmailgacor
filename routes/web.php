<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { return redirect('/login'); });

// TEMPORARY: Migration runner — hapus setelah dijalankan
Route::get('/run-migrate-setor2026', function () {
    if (request('token') !== 'setor2026deploy') {
        abort(403);
    }
    try {
        $output = new \Symfony\Component\Console\Output\BufferedOutput();
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true], $output);
        return '<pre style="background:#111;color:#0f0;padding:20px;font-family:monospace;">'
            . '✅ Migration Output:<br><br>'
            . htmlspecialchars($output->fetch())
            . '<br><a href="/admin/setoran" style="color:#0af;">→ Buka Verifikasi Setoran</a></pre>';
    } catch (\Exception $e) {
        return '<pre style="background:#111;color:#f44;padding:20px;">❌ ERROR: ' . htmlspecialchars($e->getMessage()) . '</pre>';
    }
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/withdrawal/submit', [DashboardController::class, 'submitWithdrawal'])->name('withdrawal.submit');
    Route::get('/job', [DashboardController::class, 'job'])->name('job');
    Route::post('/job/submit', [DashboardController::class, 'submitJob'])->name('job.submit');
    Route::get('/riwayat', [DashboardController::class, 'history'])->name('history');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

        Route::get('/admin/setoran', [App\Http\Controllers\Admin\SetoranController::class, 'index'])->name('admin.setoran.index');
        Route::post('/admin/setoran/{id}/approve', [App\Http\Controllers\Admin\SetoranController::class, 'approve'])->name('admin.setoran.approve');
        Route::post('/admin/setoran/{id}/reject', [App\Http\Controllers\Admin\SetoranController::class, 'reject'])->name('admin.setoran.reject');
        Route::post('/admin/setoran/{id}/mark-read', [App\Http\Controllers\Admin\SetoranController::class, 'markRead'])->name('admin.setoran.markRead');
        
        Route::get('/admin/penarikan', [App\Http\Controllers\Admin\PenarikanController::class, 'index'])->name('admin.penarikan.index');
        Route::post('/admin/penarikan/{id}/approve', [App\Http\Controllers\Admin\PenarikanController::class, 'approve'])->name('admin.penarikan.approve');
        Route::post('/admin/penarikan/{id}/reject', [App\Http\Controllers\Admin\PenarikanController::class, 'reject'])->name('admin.penarikan.reject');
        Route::post('/admin/penarikan/{id}/mark-read', [App\Http\Controllers\Admin\PenarikanController::class, 'markRead'])->name('admin.penarikan.markRead');

        Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::put('/admin/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
