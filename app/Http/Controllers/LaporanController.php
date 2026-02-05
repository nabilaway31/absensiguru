<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * =========================
     * TAMPILAN LAPORAN (WEB)
     * =========================
     */
    public function index(Request $request)
    {
        $query = Absensi::with('guru');

        // Filter Tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        // Filter Pencarian Nama/NIP (Satu-satunya yang kurang di fungsi cetak Anda sebelumnya)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('guru', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")->orWhere('nip', 'like', "%$q%");
            });
        }

        $laporan = $query->orderBy('tanggal', 'desc')->paginate(15);

        // Simpan variabel laporan ke view
        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * =========================
     * CETAK LAPORAN PDF
     * =========================
     */
    public function cetak()
    {
        $request = request();
        $query = Absensi::with('guru');

        // Filter Tanggal (Sama dengan index)
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        // TAMBAHAN: Masukkan filter pencarian nama agar PDF tersaring sesuai input "Cari"
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('guru', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")->orWhere('nip', 'like', "%$q%");
            });
        }

        $laporan = $query->orderBy('tanggal', 'desc')->get();

        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $jam = Carbon::now()->format('H:i');

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'laporan' => $laporan,
            'tanggal' => $tanggal,
            'jam' => $jam,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-absensi-guru.pdf');
    }
}
