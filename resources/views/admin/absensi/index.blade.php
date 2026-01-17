@extends('admin.layouts.app')

@section('title', 'Absensi Guru')

@section('content')
    @component('components.tw-card')
    @slot('header')
    <div class="flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
            </path>
        </svg>
        <h5 class="text-lg font-semibold">Data Absensi Guru</h5>
    </div>
    <div class="flex items-center gap-2">
        <form action="{{ route('absensi.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau NIP"
                class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg" />
            <button type="submit" class="px-3 py-1.5 bg-white border rounded-lg text-gray-700">Cari</button>
        </form>
    </div>
    <a href="/absensi/tambah"
        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Absensi</span>
    </a>
    @endslot

    @component('components.tw-table')
    @slot('head')
    <tr>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Approval</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Datang</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
    </tr>
    @endslot

    @forelse ($absensi as $no => $a)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $no + 1 }}</td>
            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $a->guru->nama }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">
                @php
                    $status = $a->status;
                    $badge = 'bg-red-100 text-red-800';
                    if ($status == 'Hadir')
                        $badge = 'bg-green-100 text-green-800';
                    elseif ($status == 'Telat')
                        $badge = 'bg-yellow-100 text-yellow-800';
                    elseif ($status == 'Izin')
                        $badge = 'bg-blue-100 text-blue-800';
                    elseif ($status == 'Sakit')
                        $badge = 'bg-teal-100 text-teal-800';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                    {{ $status }}
                </span>
            </td>
            <td class="px-4 py-3 text-center text-sm">
                @if(in_array($a->status, ['Izin', 'Sakit']))
                    @if($a->approval_status === 'pending')
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                            Menunggu
                        </span>
                    @elseif($a->approval_status === 'approved')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            Disetujui
                        </span>
                    @elseif($a->approval_status === 'rejected')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                            Ditolak
                        </span>
                    @endif
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $a->jam_datang ?? '-' }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $a->jam_pulang ?? '-' }}</td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                    <a href="{{ route('absensi.show', $a->id) }}" title="Detail"
                        class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </a>
                    @if(in_array($a->status, ['Izin', 'Sakit']) && $a->approval_status === 'pending')
                        <form action="{{ route('absensi.approve', $a->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Setujui"
                                class="inline-flex items-center justify-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        </form>
                        <button onclick="rejectModal({{ $a->id }})" title="Tolak"
                            class="inline-flex items-center justify-center px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    @endif
                    <a href="/absensi/edit/{{ $a->id }}"
                        class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </a>
                    <button onclick="hapus({{ $a->id }})"
                        class="inline-flex items-center justify-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Belum ada data absensi
            </td>
        </tr>
    @endforelse
    @endcomponent

    <div class="mt-4">
        {{ $absensi->appends(request()->query())->links() }}
    </div>
    @endcomponent

    <script>
        function hapus(id) {
            Swal.fire({
                title: 'Yakin?',
                text: 'Data absensi akan dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/absensi/hapus/' + id;
                }
            });
        }

        function rejectModal(id) {
            Swal.fire({
                title: 'Tolak Izin/Sakit',
                input: 'textarea',
                inputLabel: 'Catatan (opsional)',
                inputPlaceholder: 'Tuliskan alasan penolakan...',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ea580c',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/absensi/reject/' + id;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    if (result.value) {
                        const note = document.createElement('input');
                        note.type = 'hidden';
                        note.name = 'approval_note';
                        note.value = result.value;
                        form.appendChild(note);
                    }
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection