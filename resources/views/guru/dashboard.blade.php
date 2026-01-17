@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="w-full space-y-6">

        {{-- WELCOME CARD --}}
        <div
            class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold">Selamat Datang, {{ $guru->nama }}!</h2>
                        <p class="text-indigo-100 text-lg mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-indigo-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-lg font-medium" id="live-time">{{ $jamSekarang }}</span>
                </div>
            </div>
        </div>

        {{-- PROFILE INFO CARD --}}
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-4 mb-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Informasi Guru</h3>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Nama Lengkap</p>
                        <p class="text-gray-900 font-semibold">{{ $guru->nama }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">No. HP</p>
                        <p class="text-gray-900 font-semibold">{{ $guru->no_hp ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 md:col-span-2">
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Alamat</p>
                        <p class="text-gray-900 font-semibold">{{ $guru->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS ABSENSI CARD --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold">Status Absensi Hari Ini</h3>
                </div>
            </div>

            <div class="p-6">
                @if ($absensiHariIni)
                    @if($absensiHariIni->status == 'Telat')
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border-2 border-yellow-300 mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-yellow-700 font-medium">Status Kehadiran</p>
                                        <p class="text-2xl font-bold text-yellow-800">Terlambat</p>
                                        <p class="text-sm text-yellow-600 mt-1">Batas jam masuk: 07:30 WIB</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($absensiHariIni->jam_datang)
                                        <p class="text-sm text-gray-600">Jam Masuk</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($absensiHariIni->jam_datang)->format('H:i') }}</p>
                                    @endif
                                    @if($absensiHariIni->jam_pulang)
                                        <p class="text-sm text-gray-600 mt-2">Jam Pulang</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Status Kehadiran</p>
                                        <p class="text-2xl font-bold text-green-700">{{ $absensiHariIni->status }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($absensiHariIni->jam_datang)
                                        <p class="text-sm text-gray-600">Jam Masuk</p>
                                        <p class="text-xl font-bold text-gray-900">{{ $absensiHariIni->jam_datang }}</p>
                                    @endif
                                    @if($absensiHariIni->jam_pulang)
                                        <p class="text-sm text-gray-600 mt-2">Jam Pulang</p>
                                        <p class="text-xl font-bold text-gray-900">{{ $absensiHariIni->jam_pulang }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border-2 border-yellow-200 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-yellow-800">Belum Melakukan Absensi</p>
                                <p class="text-sm text-yellow-700">Silakan lakukan absensi masuk terlebih dahulu</p>
                                <p class="text-xs text-yellow-600 mt-1">Batas jam masuk: 07:30 WIB (Lewat = Terlambat)</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- TOMBOL ABSEN --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <form action="{{ route('guru_user.absen.masuk') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full group relative overflow-hidden {{ $absensiHariIni ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800' }} text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all duration-300"
                            {{ $absensiHariIni ? 'disabled' : '' }}>
                            <div class="flex items-center justify-center gap-3 relative z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span class="text-lg">Absen Masuk</span>
                            </div>
                            @if(!$absensiHariIni)
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -translate-x-full group-hover:translate-x-full transition-all duration-1000">
                                </div>
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('guru_user.absen.pulang') }}" method="POST">
                        @csrf
                        @php
                            $isDisabled = !$absensiHariIni || in_array($absensiHariIni?->status, ['Izin', 'Sakit']);
                        @endphp
                        <button type="submit"
                            class="w-full group relative overflow-hidden {{ $isDisabled ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800' }} text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all duration-300"
                            {{ $isDisabled ? 'disabled' : '' }}>
                            <div class="flex items-center justify-center gap-3 relative z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span class="text-lg">Absen Pulang</span>
                            </div>
                            @if($absensiHariIni && !in_array($absensiHariIni->status, ['Izin', 'Sakit']))
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -translate-x-full group-hover:translate-x-full transition-all duration-1000">
                                </div>
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Update live time
        function updateTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const el = document.getElementById('live-time');
            if (el) el.textContent = timeStr;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
@endsection