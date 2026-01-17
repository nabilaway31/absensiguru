<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('guru', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")->orWhere('nip', 'like', "%$q%");
            });
        }

        $laporan = $query->orderBy('tanggal', 'desc')->paginate(15);
        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * =========================
     * CETAK LAPORAN PDF
     * =========================
     */
    public function cetak()
    {
        // Terima filter dari query string (sama seperti index)
        $request = request();
        $query = Absensi::with('guru');
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }
        $laporan = $query->orderBy('tanggal', 'desc')->get();

        // Tanggal & jam cetak
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
