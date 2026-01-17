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
        <form action="{{ route('guru.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau NIP"
                class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg" />
            <button type="submit" class="px-3 py-1.5 bg-white border rounded-lg text-gray-700">Cari</button>
        </form>
    </div>
    @endslot

    @component('components.tw-table')
    @slot('head')
    <tr>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HP</th>
        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
    </tr>
    @endslot

    @foreach ($guru as $no => $g)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $no + 1 }}</td>
            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $g->nip }}</td>
            <td class="px-4 py-3 text-sm text-gray-800">{{ $g->nama }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $g->jenis_kelamin }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $g->no_hp }}</td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
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
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/guru/hapus/' + id;
                }
            });
        }
    </script>
@endsection