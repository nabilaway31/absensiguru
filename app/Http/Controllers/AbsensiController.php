<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /* =====================================================
     | ADMIN
     ===================================================== */

    // Tampilkan semua absensi (Admin)
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

    // Form tambah absensi manual (Admin)
    public function create()
    {
        $guru = Guru::all();

        return view('admin.absensi.create', compact('guru'));
    }

    // Simpan absensi manual (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Telat,Izin,Sakit,Alfa',
            'jam_datang' => 'nullable',
            'jam_pulang' => 'nullable',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi upload bukti
        ]);

        // CEK DATA GANDA
        $exists = Absensi::where('guru_id', $request->guru_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->with('duplicate_entry', 'Guru tersebut sudah memiliki data absensi pada tanggal tersebut!');
        }

        $data = $request->all();

        // PROSES UPLOAD BUKTI (Admin manual)
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/bukti_izin', $nama_file); // Simpan ke storage
            $data['bukti'] = $nama_file;
        }

        Absensi::create($data);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    // Edit absensi (Admin)
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $guru = Guru::all();

        return view('admin.absensi.edit', compact('absensi', 'guru'));
    }

    // Update absensi (Admin)
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

        // PROSES UPDATE BUKTI
        if ($request->hasFile('bukti')) {
            // Hapus foto lama jika ada
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

    // Hapus absensi (Admin)
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);

        // Hapus file bukti dari storage saat data dihapus
        if ($absensi->bukti) {
            Storage::delete('public/bukti_izin/'.$absensi->bukti);
        }

        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    // Show detail absensi (Admin)
    public function show($id)
    {
        $absensi = Absensi::with('guru')->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }

    // Approve izin/sakit (Admin)
    public function approve($id)
    {
        $absensi = Absensi::findOrFail($id);
        if (! in_array($absensi->status, ['Izin', 'Sakit'])) {
            return back()->with('error', 'Hanya izin/sakit yang bisa di-approve');
        }
        $absensi->update(['approval_status' => 'approved']);

        return back()->with('success', 'Izin/Sakit telah disetujui');
    }

    // Reject izin/sakit (Admin)
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

    // Dashboard absensi user (hari ini)
    public function userIndex()
    {
        $today = Carbon::today();

        $absensiHariIni = Absensi::where('guru_id', auth()->user()->guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        return view('user.absensi', compact('absensiHariIni'));
    }

    // Absen Masuk (Jam Datang Otomatis)
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

        return redirect()->back()
            ->with('success', 'Absen masuk berhasil');
    }

    // Absen Pulang (Jam Pulang Otomatis)
    public function absenPulang()
    {
        $today = Carbon::today();

        $absensi = Absensi::where('guru_id', auth()->user()->guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $absensi || ! $absensi->jam_datang) {
            return redirect()->back()
                ->with('error', 'Anda belum absen masuk');
        }

        if ($absensi->jam_pulang) {
            return redirect()->back()
                ->with('error', 'Anda sudah absen pulang');
        }

        $absensi->update([
            'jam_pulang' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Absen pulang berhasil');
    }
}
