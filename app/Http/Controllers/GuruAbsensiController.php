<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruAbsensiController extends Controller
{
    // Konstanta batas jam masuk (format 24 jam)
    const JAM_BATAS_MASUK = '07:30';

    /**
     * =========================
     * ABSEN MASUK
     * Jam masuk otomatis
     * TELAT jika > 07:00
     * Dikunci 05:00 - 09:00
     * =========================
     */
    public function absenMasuk(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i');

        if ($jamSekarang < '05:00') {
            return back()->with('error', 'Absen masuk hanya bisa mulai jam 05:00');
        }

        // Cek sudah absen atau belum
        $cek = Absensi::where('guru_id', $guru->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen hari ini');
        }

        // Tentukan status: Hadir atau Telat
        $jamMasuk = Carbon::now()->format('H:i');
        $status = ($jamMasuk > self::JAM_BATAS_MASUK) ? 'Telat' : 'Hadir';

        // Simpan absensi
        Absensi::create([
            'guru_id' => $guru->id,
            'tanggal' => $tanggal,
            'jam_datang' => $jamSekarang,
            'status' => $status,
        ]);

        $message = $status === 'Telat'
            ? "Absen masuk berhasil! Anda terlambat. Batas jam masuk: " . self::JAM_BATAS_MASUK
            : "Absen masuk berhasil!";

        return back()->with('success', $message);
    }

    /**
     * =========================
     * ABSEN PULANG
     * Tanpa batas waktu
     * =========================
     */
    public function absenPulang()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i');

        $absensi = Absensi::where('guru_id', $guru->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum absen masuk');
        }

        if ($absensi->jam_pulang) {
            return back()->with('error', 'Anda sudah absen pulang');
        }

        $absensi->update([
            'jam_pulang' => $jamSekarang,
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }

    /**
     * =========================
     * REKAP ABSENSI INDIVIDU
     * + FILTER BULAN, TAHUN, STATUS
     * =========================
     */
    public function rekap(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $query = Absensi::where('guru_id', $guru->id);

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensi = $query
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.absensi.rekap', compact('guru', 'absensi'));
    }
}
