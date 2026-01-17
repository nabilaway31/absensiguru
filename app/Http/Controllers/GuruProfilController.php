<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruProfilController extends Controller
{
    /**
     * TAMPILKAN PROFIL GURU
     */
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        return view('guru.profil.index', compact('guru'));
    }

    /**
     * UPDATE PROFIL GURU
     */
    public function update(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $guru->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
