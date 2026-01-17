<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
/* ================= CONTROLLER ADMIN ================= */
use App\Http\Controllers\GuruAbsensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\GuruProfilController;
/* ================= CONTROLLER GURU ================= */
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GuruIzinController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return redirect()->route('login');
});
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('index');
        Route::get('/tambah', [GuruController::class, 'create'])->name('create');
        Route::post('/simpan', [GuruController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [GuruController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [GuruController::class, 'update'])->name('update');
        Route::get('/hapus/{id}', [GuruController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::get('/show/{id}', [AbsensiController::class, 'show'])->name('show');
        Route::post('/approve/{id}', [AbsensiController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [AbsensiController::class, 'reject'])->name('reject');
        Route::get('/tambah', [AbsensiController::class, 'create'])->name('create');
        Route::post('/simpan', [AbsensiController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AbsensiController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AbsensiController::class, 'update'])->name('update');
        Route::get('/hapus/{id}', [AbsensiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/cetak', [LaporanController::class, 'cetak'])->name('cetak');
    });
});

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru-user')
    ->name('guru_user.')
    ->group(function () {

        Route::get('/dashboard', [GuruDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/absen-masuk', [GuruAbsensiController::class, 'absenMasuk'])
            ->name('absen.masuk');

        Route::post('/absen-pulang', [GuruAbsensiController::class, 'absenPulang'])
            ->name('absen.pulang');

        Route::get('/rekap', [GuruAbsensiController::class, 'rekap'])
            ->name('rekap');

        Route::get('/profil', [GuruProfilController::class, 'index'])
            ->name('profil');

        Route::post('/profil/update', [GuruProfilController::class, 'update'])
            ->name('profil.update');

        // Izin / Sakit (Guru)
        Route::prefix('izin')->name('izin.')->group(function () {
            Route::get('/', [GuruIzinController::class, 'index'])->name('index');
            Route::get('/tambah', [GuruIzinController::class, 'create'])->name('create');
            Route::post('/simpan', [GuruIzinController::class, 'store'])->name('store');
        });
    });

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
