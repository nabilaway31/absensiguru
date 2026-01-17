@extends('layouts.app')

@section('title', 'Absensi Guru')

@section('content')
<div class="card shadow">
    <div class="card-header text-white" style="background:#1f2a44">
        <h5 class="mb-0">🧑‍🎓 Absensi Guru</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jam Datang</th>
                    <th>Jam Pulang</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($absensi as $no => $a)
                <tr>
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td>{{ $a->guru->nama }}</td>
                    <td class="text-center">{{ $a->tanggal }}</td>
                    <td class="text-center">
                        <span class="badge 
                            {{ $a->status == 'Hadir' ? 'bg-success' : 
                               ($a->status == 'Izin' ? 'bg-warning' : 
                               ($a->status == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $a->jam_datang ?? '-' }}
                    </td>
                    <td class="text-center">
                        {{ $a->jam_pulang ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
