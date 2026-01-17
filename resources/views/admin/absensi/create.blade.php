@extends('admin.layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<div class="card shadow border-0">
    <div class="card-header text-white" style="background:#1f2a44">
        <h5 class="mb-0">📝 Tambah Absensi Guru</h5>
    </div>

    <div class="card-body">
        <form action="/absensi/simpan" method="POST">
            @csrf

            {{-- Guru --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <select name="guru_id" class="form-control" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($guru as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alfa">Alfa</option>
                </select>
            </div>

            {{-- Jam Datang & Pulang --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Datang</label>
                    <input type="time" name="jam_datang" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    💾 Simpan
                </button>
                <a href="/absensi" class="btn btn-secondary">
                    ⬅ Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
