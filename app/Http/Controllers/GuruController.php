<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input bulan dan tahun, default ke bulan/tahun saat ini
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $query = Guru::query();

        // Hitung statistik dengan filter bulan dan tahun
        $query->withCount([
            'absensi as total_hadir' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Hadir'),
            'absensi as total_izin' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin'),
            'absensi as total_sakit' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Sakit'),
            'absensi as total_telat' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Telat'),
            'absensi as total_alfa' => fn ($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alfa'),
        ]);

        // Logika pencarian nama/NIP
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('nama', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%");
            });
        }

        $guru = $query->orderBy('nama')->paginate(15);

        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        Guru::create([
            'user_id' => Auth::id(), // INI YANG HILANG
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate');
    }

    public function destroy($id)
    {
        Guru::destroy($id);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
