<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        // Ambil data guru dari user login
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Tanggal hari ini (AMAN)
        $hariIni = Carbon::today();

        // Ambil absensi hari ini
        $absensiHariIni = Absensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', $hariIni)
            ->first();

        // Waktu server sekarang untuk inisialisasi tampilan
        $jamSekarang = Carbon::now()->format('H:i:s');

        return view('guru.dashboard', compact(
            'guru',
            'absensiHariIni',
            'hariIni',
            'jamSekarang'
        ));
    }
}
