<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan library dompdf sudah terinstal

class GuruAbsensiController extends Controller
{
    /**
     * Helper untuk mengambil setting berdasarkan key
     */
    private function getSetting($key, $default)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

    /**
     * TAMPILAN DASHBOARD / HALAMAN ABSENSI
     * Tambahkan fungsi ini untuk mengirimkan status tombol ke view
     */
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tanggal = Carbon::today()->format('Y-m-d');

        // Ambil data absen hari ini untuk mengecek status tombol
        $absensiHariIni = Absensi::where('guru_id', $guru->id)
            ->where('tanggal', $tanggal)
            ->first();

        // Mengambil setting jam pulang untuk validasi di sisi View (Blade)
        $jamPulangSetting = $this->getSetting('jam_pulang', '15:00');

        return view('guru.dashboard', compact('guru', 'absensiHariIni', 'jamPulangSetting'));
    }

    public function store(Request $request)
    {
        // ... validasi ...

        $data = $request->all();
        $data['guru_id'] = auth()->user()->guru->id;

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $nama_file = time().'_'.$file->getClientOriginalName();

            // Simpan ke storage/app/public/bukti_izin
            $file->storeAs('public/bukti_izin', $nama_file);

            $data['bukti'] = $nama_file;
        }

        \App\Models\Absensi::create($data);

        return redirect()->back()->with('success', 'Data izin berhasil dikirim.');
    }

    /**
     * ABSEN MASUK
     */
    public function absenMasuk(Request $request)
    {
        // 1. Cek Hari Libur (Sabtu & Minggu)
        if (Carbon::now()->isWeekend()) {
            return back()->with('error', 'Hari ini adalah hari libur. Tidak bisa melakukan absensi.');
        }

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jamBatasMasuk = $this->getSetting('jam_masuk', '07:30');

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');

        $cek = Absensi::where('guru_id', $guru->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen hari ini');
        }

        $jamMasukInput = Carbon::now()->format('H:i');
        $status = ($jamMasukInput > $jamBatasMasuk) ? 'Telat' : 'Hadir';

        Absensi::create([
            'guru_id' => $guru->id,
            'tanggal' => $tanggal,
            'jam_datang' => $jamSekarang,
            'status' => $status,
        ]);

        $message = $status === 'Telat'
            ? "Absen masuk berhasil! Status: Terlambat (Batas jam masuk: $jamBatasMasuk WIB)"
            : 'Absen masuk berhasil! Status: Tepat Waktu';

        return back()->with('success', $message);
    }

    /**
     * ABSEN PULANG
     */
    public function absenPulang()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jamPulangSetting = $this->getSetting('jam_pulang', '15:00');

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i');

        $absensi = Absensi::where('guru_id', $guru->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (! $absensi) {
            return back()->with('error', 'Anda belum absen masuk');
        }

        if ($absensi->jam_pulang) {
            return back()->with('error', 'Anda sudah absen pulang');
        }

        if ($jamSekarang < $jamPulangSetting) {
            return back()->with('error', "Belum waktunya pulang. Jam pulang diatur pada pukul $jamPulangSetting WIB");
        }

        $absensi->update([
            'jam_pulang' => $jamSekarang,
        ]);

        return back()->with('success', 'Absen pulang berhasil. Selamat beristirahat!');
    }

    /**
     * REKAP ABSENSI INDIVIDU & CETAK PDF
     */
    public function rekap(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $query = Absensi::where('guru_id', $guru->id);

        // Filter Rentang Tanggal (Sama seperti logika Laporan Admin)
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        // Logika Cetak PDF (Tetap)
        if ($request->action == 'cetak') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru.absensi.cetak_pdf', compact('guru', 'absensi'));

            return $pdf->stream('Rekap-Absensi-'.$guru->nama.'.pdf');
        }

        return view('guru.absensi.rekap', compact('guru', 'absensi'));
    }
}
