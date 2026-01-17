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
        class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-sm px-4 py-2 rounded-lg">
        Kembali
    </a>
    @endslot

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="text-sm text-gray-500">Status</p>
            <p class="mt-2 font-semibold">{{ $absensi->status }}</p>

            @if(in_array($absensi->status, ['Izin', 'Sakit']))
                <p class="text-sm text-gray-500 mt-4">Status Persetujuan</p>
                <p class="mt-2">
                    @if($absensi->approval_status === 'pending')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">Menunggu</span>
                    @elseif($absensi->approval_status === 'approved')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Disetujui</span>
                    @elseif($absensi->approval_status === 'rejected')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Ditolak</span>
                    @endif
                </p>
                @if($absensi->approval_note)
                    <p class="text-sm text-gray-500 mt-4">Catatan Penolakan</p>
                    <p class="mt-2 text-gray-800 text-sm">{{ $absensi->approval_note }}</p>
                @endif
            @endif

            @if($absensi->keterangan)
                <p class="text-sm text-gray-600 mt-4">Keterangan</p>
                <p class="mt-2 text-gray-800">{{ $absensi->keterangan }}</p>
            @endif

            <p class="text-sm text-gray-500 mt-4">Jam Datang</p>
            <p class="mt-1">{{ $absensi->jam_datang ?? '-' }}</p>

            <p class="text-sm text-gray-500 mt-4">Jam Pulang</p>
            <p class="mt-1">{{ $absensi->jam_pulang ?? '-' }}</p>
        </div>

        <div class="bg-white rounded-lg p-4 shadow">
            <p class="text-sm text-gray-500">Bukti</p>
            <div class="mt-3">
                @php
                    $exists = $absensi->bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($absensi->bukti);
                @endphp

                @if($exists)
                    @php $ext = strtolower(pathinfo($absensi->bukti, PATHINFO_EXTENSION)); @endphp
                    @php $url = asset('storage/' . ltrim($absensi->bukti, '/')); @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ $url }}" alt="Bukti" class="max-w-full rounded-md border" />
                    @elseif($ext === 'pdf')
                        <p class="text-sm text-gray-700">File PDF: <a href="{{ $url }}" target="_blank"
                                class="text-indigo-600 hover:underline">Buka bukti (PDF)</a></p>
                    @else
                        <p class="text-sm text-gray-700">Tipe file: {{ $ext }} — <a href="{{ $url }}" target="_blank"
                                class="text-indigo-600 hover:underline">Download</a></p>
                    @endif
                @else
                    <p class="text-sm text-gray-500">Tidak ada bukti terlampir atau file tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
    @endcomponent
@endsection