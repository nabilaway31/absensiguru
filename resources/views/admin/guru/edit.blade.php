@extends('admin.layouts.app')

@section('title', 'Edit Guru')

@section('content')
<div class="w-full">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <div class="px-4 py-3 bg-gray-800 text-white flex items-center gap-3">
            <i class="bi bi-pencil-square text-lg"></i>
            <h5 class="text-lg font-semibold">Edit Guru</h5>
        </div>

        <div class="p-6">
            <form action="/guru/update/{{ $guru->id }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin)=='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin)=='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $guru->alamat) }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="/guru" class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
