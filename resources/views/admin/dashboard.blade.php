@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="w-full space-y-6">

        {{-- CARD STATISTIK (HARI INI) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- TOTAL GURU --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-5 flex items-center gap-4 hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-600 to-indigo-700 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Total Guru</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalGuru }}</div>
                    <div class="text-xs text-gray-400 mt-1">Keseluruhan data guru</div>
                </div>
            </div>

            {{-- HADIR --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-5 flex items-center gap-4 hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Hadir</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $hadir }}</div>
                    <div class="text-xs text-gray-400 mt-1">Jumlah hadir hari ini</div>
                </div>
            </div>

            {{-- IZIN --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-5 flex items-center gap-4 hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Izin</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $izin }}</div>
                    <div class="text-xs text-gray-400 mt-1">Jumlah izin hari ini</div>
                </div>
            </div>

            {{-- SAKIT --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-5 flex items-center gap-4 hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-red-600 to-red-700 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Sakit</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $sakit }}</div>
                    <div class="text-xs text-gray-400 mt-1">Jumlah sakit hari ini</div>
                </div>
            </div>
        </div>

        {{-- TABEL ABSENSI HARI INI --}}
        @component('components.tw-card')
            @slot('header')
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h5 class="text-lg font-semibold">Absensi Guru Hari Ini</h5>
            </div>
            <span class="text-sm text-gray-200">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
            @endslot

            @component('components.tw-table')
                @slot('head')
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Jam Datang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Jam Pulang</th>
                </tr>
                @endslot

                @forelse ($absensiHariIni as $no => $a)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $no + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $a->guru->nama }}</td>
                        <td class="px-4 py-3 text-sm">
                            @php
                                $s = $a->status;
                                $badge = match($s) {
                                    'Hadir' => 'bg-green-100 text-green-800',
                                    'Telat' => 'bg-yellow-100 text-yellow-800',
                                    'Izin'  => 'bg-blue-100 text-blue-800',
                                    'Sakit' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $s }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $a->jam_datang ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $a->jam_pulang ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                            Belum ada absensi hari ini
                        </td>
                    </tr>
                @endforelse
            @endcomponent
        @endcomponent

        {{-- --- TAMBAHAN: TABEL PERINGKAT KEHADIRAN GURU (TOP 5) --- --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <h5 class="text-lg font-bold">Statistik Akumulasi Kehadiran Guru</h5>
                </div>
                <span class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Data Keseluruhan</span>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-bold text-gray-700 uppercase text-xs">Nama Guru</th>
                            <th class="px-4 py-4 text-center font-bold text-emerald-600 uppercase text-xs">Hadir</th>
                            <th class="px-4 py-4 text-center font-bold text-blue-600 uppercase text-xs">Izin</th>
                            <th class="px-4 py-4 text-center font-bold text-amber-600 uppercase text-xs">Sakit</th>
                            <th class="px-4 py-4 text-center font-bold text-red-600 uppercase text-xs">Alfa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($topAbsensi as $guru)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $guru->nama }}</div>
                                <div class="text-xs text-gray-500">NIP: {{ $guru->nip ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-block min-w-[32px] bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md font-bold">
                                    {{ $guru->total_hadir }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center text-gray-600 font-medium">{{ $guru->total_izin }}</td>
                            <td class="px-4 py-4 text-center text-gray-600 font-medium">{{ $guru->total_sakit }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="{{ $guru->total_alfa > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                                    {{ $guru->total_alfa }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-gray-100">
                <p class="text-[10px] text-gray-400 italic font-medium">* Peringkat diurutkan berdasarkan jumlah kehadiran terbanyak.</p>
            </div>
        </div>

    </div>

@endsection