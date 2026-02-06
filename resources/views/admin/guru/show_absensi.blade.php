@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Profil & Tombol Cetak --}}
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $guru->nama }}</h2>
            <p class="text-gray-500 text-sm font-medium">NIP: {{ $guru->nip ?? '-' }}</p>
        </div>
        
        {{-- Tombol Cetak (Otomatis mengikuti filter bulan/tahun) --}}
        <a href="{{ route('guru.cetak', [$guru->id, 'bulan' => request('bulan', date('m')), 'tahun' => request('tahun', date('Y'))]) }}" 
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            CETAK PDF BULAN INI
        </a>
    </div>

    {{-- DROPDOWN REKAP PER BULAN --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap items-center justify-between gap-4">
        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Bulan:</label>
                <select name="bulan" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-slate-800 focus:border-slate-800 p-2">
                    @foreach(range(1, 12) as $m)
                        {{-- Casting (int) pada request untuk mencegah TypeError Carbon --}}
                        <option value="{{ $m }}" {{ (int)request('bulan', date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month((int)$m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tahun:</label>
                <select name="tahun" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-slate-800 focus:border-slate-800 p-2">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ (int)request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
        </form>
        
        <div class="text-right">
            <span class="text-xs font-bold text-gray-400 uppercase block">Periode Laporan</span>
            <span class="text-sm font-bold text-slate-800">
                {{-- Casting (int) pada Carbon create untuk keamanan tipe data --}}
                {{ \Carbon\Carbon::create()->month((int)request('bulan', date('m')))->translatedFormat('F') }} {{ request('tahun', date('Y')) }}
            </span>
        </div>
    </div>

    {{-- Ringkasan Total (Data akan otomatis berubah sesuai filter di Controller) --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-center shadow-sm">
            <div class="text-[10px] text-emerald-600 font-black uppercase tracking-widest">Hadir</div>
            <div class="text-2xl font-black text-emerald-700">{{ $guru->total_hadir }}</div>
        </div>
        <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl text-center shadow-sm">
            <div class="text-[10px] text-blue-600 font-black uppercase tracking-widest">Izin</div>
            <div class="text-2xl font-black text-blue-700">{{ $guru->total_izin }}</div>
        </div>
        <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl text-center shadow-sm">
            <div class="text-[10px] text-amber-600 font-black uppercase tracking-widest">Sakit</div>
            <div class="text-2xl font-black text-amber-700">{{ $guru->total_sakit }}</div>
        </div>
        <div class="p-4 bg-orange-50 border border-orange-100 rounded-xl text-center shadow-sm">
            <div class="text-[10px] text-orange-600 font-black uppercase tracking-widest">Telat</div>
            <div class="text-2xl font-black text-orange-700">{{ $guru->total_telat }}</div>
        </div>
        <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-center shadow-sm">
            <div class="text-[10px] text-red-600 font-black uppercase tracking-widest">Alfa</div>
            <div class="text-2xl font-black text-red-700">{{ $guru->total_alfa }}</div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-slate-800 px-6 py-4">
            <h5 class="text-white font-bold text-sm uppercase tracking-wider">Riwayat Kedatangan</h5>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 font-bold text-gray-500 uppercase text-xs">Tanggal</th>
                    <th class="px-6 py-3 font-bold text-gray-500 uppercase text-xs text-center">Status</th>
                    <th class="px-6 py-3 font-bold text-gray-500 uppercase text-xs text-center">Jam Datang</th>
                    <th class="px-6 py-3 font-bold text-gray-500 uppercase text-xs text-center">Jam Pulang</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($guru->absensi as $absen)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $absen->status == 'Hadir' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $absen->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-gray-600">{{ $absen->jam_datang ?? '--:--' }}</td>
                    <td class="px-6 py-4 text-center font-mono text-gray-600">{{ $absen->jam_pulang ?? '--:--' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                        Tidak ada data absensi untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection