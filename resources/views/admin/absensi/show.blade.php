@extends('admin.layouts.app')

@section('title', 'Detail Absensi')

@section('content')
    @component('components.tw-card')
    @slot('header')
    <div class="flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
            </path>
        </svg>
        <div>
            <h5 class="text-lg font-semibold">Detail Absensi</h5>
            <p class="text-sm text-indigo-100">{{ $absensi->guru->nama ?? '-' }} —
                {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}
            </p>
        </div>
    </div>
    <a href="{{ route('absensi.index') }}"
        class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-sm px-4 py-2 rounded-lg text-gray-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
    @endslot

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Kiri: Informasi Status & Waktu --}}
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="text-sm text-gray-500 font-medium">Status Kehadiran</p>
            <p class="mt-2 font-bold text-gray-900 text-lg">{{ $absensi->status }}</p>

            @if(in_array($absensi->status, ['Izin', 'Sakit']))
                <p class="text-sm text-gray-500 mt-4 font-medium">Status Persetujuan</p>
                <div class="mt-2">
                    @if($absensi->approval_status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800 border border-orange-200">Menunggu</span>
                    @elseif($absensi->approval_status === 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">Disetujui</span>
                    @elseif($absensi->approval_status === 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                    @endif
                </div>

                @if($absensi->approval_note)
                    <p class="text-sm text-gray-500 mt-4 font-medium">Catatan Admin</p>
                    <p class="mt-2 p-3 bg-gray-50 rounded-lg text-gray-800 text-sm italic">"{{ $absensi->approval_note }}"</p>
                @endif
            @endif

            @if($absensi->keterangan)
                <p class="text-sm text-gray-600 mt-4 font-medium">Alasan / Keterangan Guru</p>
                <p class="mt-2 text-gray-800 text-sm leading-relaxed">{{ $absensi->keterangan }}</p>
            @endif

            <hr class="my-6 border-gray-100">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Jam Datang</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ $absensi->jam_datang ?? '--:--' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Jam Pulang</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ $absensi->jam_pulang ?? '--:--' }}</p>
                </div>
            </div>
        </div>

        {{-- Kanan: Bukti Lampiran (Perbaikan Utama) --}}
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="text-sm text-gray-500 font-bold mb-4 uppercase tracking-wider">Bukti Lampiran</p>
            <div class="mt-3">
                @if($absensi->bukti)
                    @php 
                        $ext = strtolower(pathinfo($absensi->bukti, PATHINFO_EXTENSION)); 
                        // Perbaikan URL: Pastikan path folder sesuai dengan tempat Anda menyimpan di Controller
                        // Secara default diarahkan ke storage/bukti_izin/
                        $url = asset('storage/bukti_izin/' . $absensi->bukti); 
                    @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                        <div class="relative group rounded-lg overflow-hidden border-2 border-gray-100">
                                    <a href="{{ asset('storage/bukti_izin/' . $absensi->bukti) }}" target="_blank">
                                        <img src="{{ asset('storage/bukti_izin/' . $absensi->bukti) }}" alt="Bukti" class="w-full h-auto transition-transform duration-500 group-hover:scale-105" />
                                    </a>                            
                                    <div class="mt-3 text-center">
                                <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    KLIK UNTUK PERBESAR GAMBAR
                                </a>
                            </div>
                        </div>
                    @elseif($ext === 'pdf')
                        <div class="flex items-center gap-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 shadow-sm">
                            <div class="bg-red-500 text-white p-2 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Dokumen Lampiran (PDF)</p>
                                <a href="{{ $url }}" target="_blank" class="text-sm text-indigo-600 font-semibold hover:underline">Buka file di tab baru</a>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 rounded-lg text-center">
                            <p class="text-sm text-gray-700">Tipe file ({{ $ext }}) tidak didukung pratinjau.</p>
                            <a href="{{ $url }}" target="_blank" class="text-sm text-indigo-600 font-bold underline mt-2 inline-block">Download File</a>
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-400 mt-3 font-medium">Tidak ada foto bukti terlampir.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endcomponent
@endsection