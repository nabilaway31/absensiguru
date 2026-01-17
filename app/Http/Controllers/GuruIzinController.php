<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GuruIzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pastikan user memiliki record guru; fallback ke query jika relation tidak di-set
        $user = Auth::user();
        $guru = $user->guru ?? Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('guru_user.dashboard')
                ->with('error', 'Profil guru tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $guruId = $guru->id;
        $query = Absensi::where('guru_id', $guruId)
            ->whereIn('status', ['Izin', 'Sakit']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('tanggal', 'like', "%$q%")
                    ->orWhere('jam_datang', 'like', "%$q%")
                    ->orWhere('jam_pulang', 'like', "%$q%");
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('guru.izin.index', compact('absensi', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // redirect ke index — form tambah sudah ada di index
        return redirect()->route('guru_user.izin.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:Izin,Sakit',
            'keterangan' => 'nullable|string|max:1000',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = Auth::user();
        $guru = $user->guru ?? Guru::where('user_id', $user->id)->first();
        if (!$guru) {
            return redirect()->route('guru_user.izin.index')
                ->with('error', 'Profil guru tidak ditemukan. Lengkapi profil terlebih dahulu.');
        }
        $guruId = $guru->id;

        $data = [
            'status' => $request->status,
            'jam_datang' => null,
            'jam_pulang' => null,
            'keterangan' => $request->keterangan,
            'approval_status' => 'pending',
        ];

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('izin', 'public');
            $data['bukti'] = $path;
        }

        Absensi::updateOrCreate(
            ['guru_id' => $guruId, 'tanggal' => $request->tanggal],
            $data
        );
        return redirect()->route('guru_user.izin.index')->with('success', 'Permintaan izin tersimpan dan menunggu persetujuan admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $Absensi)
    {
        return view('guru.izin.show', compact('Absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $Absensi)
    {
        return view('guru.izin.edit', compact('Absensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $Absensi)
    {
        $request->validate([
            'status' => 'required|in:Izin,Sakit',
            'keterangan' => 'nullable|string|max:1000',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $update = $request->only('status', 'keterangan');
        if ($request->hasFile('bukti')) {
            // hapus file lama jika ada
            if ($Absensi->bukti) {
                Storage::disk('public')->delete($Absensi->bukti);
            }
            $update['bukti'] = $request->file('bukti')->store('izin', 'public');
        }

        $Absensi->update($update);
        return back()->with('success', 'Data izin diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $Absensi)
    {
        $Absensi->delete();
        return back()->with('success', 'Data izin dihapus');
    }
}
