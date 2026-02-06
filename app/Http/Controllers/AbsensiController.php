<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /* =====================================================
     | ADMIN
     ===================================================== */

    public function index(Request $request)
    {
        $query = Absensi::with('guru');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('guru', function ($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")->orWhere('nip', 'like', "%$q%");
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('admin.absensi.index', compact('absensi'));
    }

    public function create()
    {
        $guru = Guru::all();

        return view('admin.absensi.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Telat,Izin,Sakit,Alfa',
            'jam_datang' => 'nullable',
            'jam_pulang' => 'nullable',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $exists = Absensi::where('guru_id', $request->guru_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->with('duplicate_entry', 'Guru tersebut sudah memiliki data absensi pada tanggal tersebut!');
        }

        $data = $request->all();

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/bukti_izin', $nama_file);
            $data['bukti'] = $nama_file;
        }

        Absensi::create($data);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $guru = Guru::all();

        return view('admin.absensi.edit', compact('absensi', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Telat,Izin,Sakit,Alfa',
            'jam_datang' => 'nullable',
            'jam_pulang' => 'nullable',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $absensi = Absensi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('bukti')) {
            if ($absensi->bukti) {
                Storage::delete('public/bukti_izin/'.$absensi->bukti);
            }

            $file = $request->file('bukti');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/bukti_izin', $nama_file);
            $data['bukti'] = $nama_file;
        }

        $absensi->update($data);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil diupdate');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);

        if ($absensi->bukti) {
            Storage::delete('public/bukti_izin/'.$absensi->bukti);
        }

        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    /**
     * Tampilan Detail Absensi Per Guru dengan Filter Bulan & Tahun
     */
    public function show(Request $request, $id)
    {
        // Casting ke (int) untuk mencegah TypeError pada Carbon::setUnit()
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $guru = Guru::with(['absensi' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->orderBy('tanggal', 'desc');
        }])->withCount([
            'absensi as total_hadir' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Hadir'),
            'absensi as total_izin' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin'),
            'absensi as total_sakit' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Sakit'),
            'absensi as total_telat' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Telat'),
            'absensi as total_alfa' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alfa'),
        ])->findOrFail($id);

        return view('admin.guru.show_absensi', compact('guru'));
    }

    public function detail($id)
    {
        $absensi = Absensi::with('guru')->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }

    /**
     * Cetak PDF Individu Guru dengan Filter Bulan & Tahun
     */
    public function cetakPerGuru(Request $request, $id)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $guru = Guru::with(['absensi' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->orderBy('tanggal', 'desc');
        }])->withCount([
            'absensi as total_hadir' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Hadir'),
            'absensi as total_izin' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin'),
            'absensi as total_sakit' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Sakit'),
            'absensi as total_telat' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Telat'),
            'absensi as total_alfa' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alfa'),
        ])->findOrFail($id);

        $absensi = $guru->absensi;
        $tanggal = Carbon::create()->month($bulan)->translatedFormat('F').' '.$tahun;

        $pdf = Pdf::loadView('guru.absensi.cetak_pdf', compact('guru', 'absensi', 'tanggal'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Absensi_'.$guru->nama.'_'.$tanggal.'.pdf');
    }

    public function approve($id)
    {
        $absensi = Absensi::findOrFail($id);
        if (! in_array($absensi->status, ['Izin', 'Sakit'])) {
            return back()->with('error', 'Hanya izin/sakit yang bisa di-approve');
        }
        $absensi->update(['approval_status' => 'approved']);

        return back()->with('success', 'Izin/Sakit telah disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['approval_note' => 'nullable|string|max:500']);
        $absensi = Absensi::findOrFail($id);
        if (! in_array($absensi->status, ['Izin', 'Sakit'])) {
            return back()->with('error', 'Hanya izin/sakit yang bisa di-reject');
        }
        $absensi->update([
            'approval_status' => 'rejected',
            'approval_note' => $request->approval_note,
        ]);

        return back()->with('success', 'Izin/Sakit telah ditolak');
    }

    /* =====================================================
     | USER / GURU
     ===================================================== */

    public function userIndex()
    {
        $today = Carbon::today();
        $absensiHariIni = Absensi::where('guru_id', auth()->user()->guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        return view('user.absensi', compact('absensiHariIni'));
    }

    public function absenMasuk()
    {
        $today = Carbon::today();
        Absensi::firstOrCreate(
            [
                'guru_id' => auth()->user()->guru->id,
                'tanggal' => $today,
            ],
            [
                'jam_datang' => now(),
                'status' => 'Hadir',
            ]
        );

        return redirect()->back()->with('success', 'Absen masuk berhasil');
    }

    public function absenPulang()
    {
        $today = Carbon::today();
        $absensi = Absensi::where('guru_id', auth()->user()->guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $absensi || ! $absensi->jam_datang) {
            return redirect()->back()->with('error', 'Anda belum absen masuk');
        }

        if ($absensi->jam_pulang) {
            return redirect()->back()->with('error', 'Anda sudah absen pulang');
        }

        $absensi->update(['jam_pulang' => now()]);

        return redirect()->back()->with('success', 'Absen pulang berhasil');
    }
}
