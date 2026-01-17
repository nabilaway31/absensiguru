<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Tanggal hari ini
        $today = Carbon::today();

        // Hitung total guru
        $totalGuru = Guru::count();

        // Hitung absensi berdasarkan status (hari ini)
        $hadir = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Hadir')
            ->count();

        $izin = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Izin')
            ->count();

        $sakit = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Sakit')
            ->count();

        // Data absensi hari ini untuk tabel dashboard
        $absensiHariIni = Absensi::with('guru')
            ->whereDate('tanggal', $today)
            ->latest()
            ->get();

        // Kirim ke view dashboard (menggunakan namespace folder admin)
        return view('admin.dashboard', compact(
            'totalGuru',
            'hadir',
            'izin',
            'sakit',
            'absensiHariIni'
        ));
    }
}
