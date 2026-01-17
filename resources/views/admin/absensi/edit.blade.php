@extends('admin.layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="card shadow border-0">
    <div class="card-header text-white d-flex align-items-center gap-2" style="background:#1f2a44">
        <i class="bi bi-journal-check fs-5"></i>
        <h5 class="mb-0">Edit Absensi Guru</h5>
    </div>

    <div class="card-body">
        <form action="/absensi/update/{{ $absensi->id }}" method="POST">
            @csrf

            {{-- Guru --}}
            <div class="mb-3">
                <label class="form-label">Nama Guru</label>
                <select name="guru_id" class="form-control" required>
                    @foreach ($guru as $g)
                        <option value="{{ $g->id }}" {{ $absensi->guru_id == $g->id ? 'selected' : '' }}>
                            {{ $g->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal & Status --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $absensi->tanggal) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Hadir" {{ $absensi->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ $absensi->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ $absensi->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alfa" {{ $absensi->status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>
            </div>

            {{-- Jam Datang & Pulang --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Datang</label>
                    <input type="time" name="jam_datang" class="form-control"
                        value="{{ old('jam_datang', $absensi->jam_datang) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control"
                        value="{{ old('jam_pulang', $absensi->jam_pulang) }}">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    💾 Update
                </button>
                <a href="/absensi" class="btn btn-secondary">
                    ⬅ Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
