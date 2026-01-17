@extends('guru.layouts.app')

@section('title', 'Izin / Sakit')

@section('content')
    <div class="w-full space-y-6">

        {{-- HEADER CARD (mirip rekap) --}}
        <div
            class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -mr-24 -mt-24"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full -ml-16 -mb-16"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Izin / Sakit</h2>
                        <p class="text-indigo-100 mt-1">{{ $guru->nama ?? '' }} - NIP: {{ $guru->nip ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATISTIK CARDS (mirip rekap dengan border-left) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $totalIzin = $absensi->where('status', 'Izin')->count();
                $totalSakit = $absensi->where('status', 'Sakit')->count();
            @endphp

            <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Izin</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalIzin }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Sakit</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSakit }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Data</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $absensi->total() }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM TAMBAH IZIN CARD (mirip filter rekap) --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h3 class="text-lg font-bold">Tambah Izin / Sakit</h3>
                </div>
            </div>

            <form action="{{ route('guru_user.izin.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Tanggal</span>
                            </div>
                        </label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" />
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status</span>
                            </div>
                        </label>
                        <select name="status" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                            <option value="">Pilih status</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>

                    {{-- Upload Bukti + Preview --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Upload Bukti (opsional)</span>
                            </div>
                        </label>

                        <input type="file" name="bukti" id="buktiInput" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />

                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF (Max 5MB)</p>

                        {{-- Preview --}}
                        <div id="previewWrapper" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-1">Preview:</p>
                            <img id="previewImage" src="" alt="Preview Bukti" class="max-w-xs rounded-lg border shadow" />
                        </div>
                    </div>

                    {{-- Deskripsi / Keterangan --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Deskripsi / Keterangan</span>
                            </div>
                        </label>
                        <textarea name="keterangan" rows="3"
                            placeholder="Contoh: Sakit demam, istirahat di rumah sesuai anjuran dokter"
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 resize-none transition-all"></textarea>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="md:col-span-2">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold py-2.5 px-4 rounded-lg shadow-lg">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Data Izin</span>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        // preview file (image/pdf)
        (function () {
            const input = document.getElementById('buktiInput');
            const wrapper = document.getElementById('previewWrapper');
            const img = document.getElementById('previewImage');

            if (!input || !wrapper) return;

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) {
                    wrapper.classList.add('hidden');
                    return;
                }

                const type = file.type;
                if (type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        wrapper.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else if (type === 'application/pdf') {
                    img.src = '';
                    img.classList.add('hidden');
                    wrapper.classList.remove('hidden');
                    wrapper.innerHTML = '<p class="text-sm text-gray-700">PDF terpilih: ' + file.name + '</p>';
                } else {
                    img.src = '';
                    img.classList.add('hidden');
                    wrapper.classList.remove('hidden');
                    wrapper.innerHTML = '<p class="text-sm text-gray-700">File terpilih: ' + file.name + '</p>';
                }
            });
        })();
    </script>
@endsection