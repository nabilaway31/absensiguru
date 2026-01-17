@extends('admin.layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
    @component('components.tw-card')
    @slot('header')
    <div class="flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        <h5 class="text-lg font-semibold">Laporan Absensi Guru</h5>
    </div>
    <div class="flex items-center gap-2">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau NIP"
                class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg" />
            <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-1.5 text-sm border rounded-lg text-gray-700" />
            <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-1.5 text-sm border rounded-lg text-gray-700" />
            <button type="submit" class="px-3 py-1.5 bg-white border rounded-lg text-gray-700">Filter</button>
        </form>
        <a href="/laporan/cetak?{{ http_build_query(request()->only(['from', 'to'])) }}"
            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                </path>
            </svg>
            Cetak PDF
        </a>
    </div>
    @endslot

    @component('components.tw-table')
    @slot('head')
    <tr>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Datang</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
    </tr>
    @endslot

    @forelse ($laporan as $no => $l)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $no + 1 }}</td>
            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $l->guru->nama }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($l->tanggal)->format('d/m/Y') }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $l->jam_datang ?? '-' }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $l->jam_pulang ?? '-' }}</td>
            <td class="px-4 py-3 text-sm">
                @php
                    $s = $l->status;
                    $badge = 'bg-red-100 text-red-800';
                    if ($s == 'Hadir')
                        $badge = 'bg-green-100 text-green-800';
                    elseif ($s == 'Telat')
                        $badge = 'bg-yellow-100 text-yellow-800';
                    elseif ($s == 'Izin')
                        $badge = 'bg-blue-100 text-blue-800';
                    elseif ($s == 'Sakit')
                        $badge = 'bg-teal-100 text-teal-800';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                    {{ $s }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Belum ada data laporan absensi
            </td>
        </tr>
    @endforelse
    @endcomponent

    <div class="mt-4">
        {{ $laporan->appends(request()->query())->links() }}
    </div>
    @endcomponent
@endsection