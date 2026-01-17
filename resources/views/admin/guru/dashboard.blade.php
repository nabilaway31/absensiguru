@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow border">
        <h2 class="text-xl font-semibold text-gray-800">
            👋 Selamat Datang, {{ $guru->nama }}
        </h2>
        <p class="text-sm text-gray-500">
            {{ now()->format('l, d F Y') }}
        </p>
    </div>

    {{-- STATUS ABSENSI --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- STATUS --}}
        <div class="bg-white p-5 rounded-lg shadow border">
            <div class="text-sm text-gray-500">Status Hari Ini</div>

            @if($absensiHariIni)
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold
                    {{ $absensiHariIni->status === 'Alfa' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                    {{ $absensiHariIni->status }}
                </span>
            @else
                <span class="inline-block mt-2 px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                    Belum Absen
                </span>
            @endif
        </div>

        {{-- JAM MASUK --}}
        <div class="bg-white p-5 rounded-lg shadow border">
            <div class="text-sm text-gray-500">Jam Masuk</div>
            <div class="mt-2 text-lg font-semibold">
                {{ $absensiHariIni->jam_masuk ?? '-' }}
            </div>
        </div>

        {{-- JAM PULANG --}}
        <div class="bg-white p-5 rounded-lg shadow border">
            <div class="text-sm text-gray-500">Jam Pulang</div>
            <div class="mt-2 text-lg font-semibold">
                {{ $absensiHariIni->jam_pulang ?? '-' }}
            </div>
        </div>
    </div>

    {{-- TOMBOL ABSEN --}}
    <div class="bg-white p-6 rounded-lg shadow border flex flex-col md:flex-row gap-4">

        {{-- ABSEN MASUK --}}
        <form action="{{ route('guru_user.absen.masuk') }}" method="POST" class="w-full">
            @csrf
            <button
                class="w-full py-3 rounded-lg font-semibold
                {{ $absensiHariIni ? 'bg-gray-300 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700 text-white' }}"
                {{ $absensiHariIni ? 'disabled' : '' }}>
                🕖 Absen Masuk
            </button>
        </form>

        {{-- ABSEN PULANG --}}
        <form action="{{ route('guru_user.absen.pulang') }}" method="POST" class="w-full">
            @csrf
            <button
                class="w-full py-3 rounded-lg font-semibold
                {{ (!$absensiHariIni || $absensiHariIni->jam_pulang) ? 'bg-gray-300 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}"
                {{ (!$absensiHariIni || $absensiHariIni->jam_pulang) ? 'disabled' : '' }}>
                🕒 Absen Pulang
            </button>
        </form>

    </div>

</div>
@endsection
