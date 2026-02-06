<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
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

        // --- TAMBAHAN: Logika Peringkat Kehadiran Guru (Top 5) ---
        // Menghitung akumulasi status dari awal data ada (bukan hanya hari ini)
        $topAbsensi = Guru::withCount([
            'absensi as total_hadir' => function ($query) {
                $query->where('status', 'Hadir');
            },
            'absensi as total_izin' => function ($query) {
                $query->where('status', 'Izin');
            },
            'absensi as total_sakit' => function ($query) {
                $query->where('status', 'Sakit');
            },
            'absensi as total_alfa' => function ($query) {
                $query->where('status', 'Alfa');
            },
        ])
            ->orderBy('total_hadir', 'desc') // Mengurutkan dari yang paling rajin hadir
            ->take(5) // Hanya mengambil 5 guru terbaik
            ->get();

        // Kirim semua variabel ke view dashboard
        return view('admin.dashboard', compact(
            'totalGuru',
            'hadir',
            'izin',
            'sakit',
            'absensiHariIni',
            'topAbsensi' // Variabel baru ditambahkan di sini
        ));
    }
}
