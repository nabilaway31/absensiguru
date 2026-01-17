<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Guru;
use App\Models\Absensi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Hitung jumlah guru (aman)
        $jumlahGuru = Schema::hasTable('gurus')
            ? Guru::count()
            : 0;

        // Hitung jumlah absensi (aman)
        $jumlahAbsensi = Schema::hasTable('absensis')
            ? Absensi::count()
            : 0;

        View::share([
            'jumlahGuru' => $jumlahGuru,
            'jumlahAbsensi' => $jumlahAbsensi,
        ]);
    }
}
