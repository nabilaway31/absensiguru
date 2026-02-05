@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <div class="max-w-2xl bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-slate-800">Pengaturan Jam Kerja</h2>
            <p class="text-sm text-slate-500">Atur jam masuk (batas telat) dan jam pulang guru.</p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Masuk (Batas Telat)</label>
                    <input type="time" name="jam_masuk" 
                        value="{{ $settings['jam_masuk'] ?? '07:30' }}" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400 font-medium">* Guru absen setelah jam ini akan berstatus "Telat"</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Pulang Minimum</label>
                    <input type="time" name="jam_pulang" 
                        value="{{ $settings['jam_pulang'] ?? '15:00' }}" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400 font-medium">* Guru tidak bisa absen pulang sebelum jam ini</p>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all transform active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection