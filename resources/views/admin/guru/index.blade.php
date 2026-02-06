@extends('admin.layouts.app')

@section('title', 'Data Guru')

@section('content')
    @component('components.tw-card')
    @slot('header')
    <div class="flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
        </svg>
        <h5 class="text-lg font-semibold">Data Guru</h5>
    </div>
    <div class="flex items-center gap-2">
        <a href="/guru/tambah"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Guru</span>
        </a>
        
        {{-- Form Pencarian & Filter Bulan --}}
        <form action="{{ route('guru.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau NIP" 
                class="px-3 py-1.5 text-sm text-black placeholder-gray-600 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"/>
            
            {{-- Dropdown Bulan --}}
            <select name="bulan" onchange="this.form.submit()" class="px-3 py-1.5 text-sm text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ (int)request('bulan', date('m')) == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            {{-- Dropdown Tahun --}}
            <select name="tahun" onchange="this.form.submit()" class="px-3 py-1.5 text-sm text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ (int)request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-black font-medium hover:bg-gray-50 transition-colors">Cari</button>
        </form>
    </div>
    @endslot

    @component('components.tw-table')
    @slot('head')
    <tr>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profil Guru</th>
        {{-- Kolom Statistik Berdasarkan Bulan Pilihan --}}
        <th class="px-2 py-3 text-center text-xs font-bold text-green-600 uppercase tracking-wider">Hadir</th>
        <th class="px-2 py-3 text-center text-xs font-bold text-yellow-600 uppercase tracking-wider">Telat</th>
        <th class="px-2 py-3 text-center text-xs font-bold text-blue-600 uppercase tracking-wider">Izin</th>
        <th class="px-2 py-3 text-center text-xs font-bold text-orange-600 uppercase tracking-wider">Sakit</th>
        <th class="px-2 py-3 text-center text-xs font-bold text-red-600 uppercase tracking-wider">Alfa</th>
        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
    </tr>
    @endslot

    @foreach ($guru as $no => $g)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-sm text-gray-700">
                {{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-bold text-gray-900">{{ $g->nama }}</div>
                <div class="text-xs text-gray-500 font-medium">NIP: {{ $g->nip }}</div>
                <div class="text-[10px] text-gray-400 italic">HP: {{ $g->no_hp }}</div>
            </td>
            
            {{-- Data Akumulasi Absensi (Filtered by Month) --}}
            <td class="px-2 py-3 text-center">
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold text-xs">{{ $g->total_hadir }}</span>
            </td>
            <td class="px-2 py-3 text-center text-sm font-semibold text-gray-600">{{ $g->total_telat }}</td>
            <td class="px-2 py-3 text-center text-sm font-semibold text-gray-600">{{ $g->total_izin }}</td>
            <td class="px-2 py-3 text-center text-sm font-semibold text-gray-600">{{ $g->total_sakit }}</td>
            <td class="px-2 py-3 text-center">
                <span class="{{ $g->total_alfa > 0 ? 'text-red-600 font-extrabold' : 'text-gray-300' }} text-sm">
                    {{ $g->total_alfa }}
                </span>
            </td>

            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                    <a href="{{ route('absensi.show', $g->id) }}" title="Lihat Detail Riwayat"
                        class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a href="/guru/edit/{{ $g->id }}" title="Edit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </a>
                    <button onclick="hapus({{ $g->id }})" title="Hapus"
                        class="inline-flex items-center justify-center w-8 h-8 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
    @endcomponent

    <div class="mt-4">
        {{ $guru->appends(request()->query())->links() ?? '' }}
    </div>
    @endcomponent

    <script>
        function hapus(id) {
            Swal.fire({
                title: 'Yakin?',
                text: 'Data guru akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Hapus Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/guru/hapus/' + id;
                }
            });
        }
    </script>
@endsection