@extends('layouts.app')

@section('title', isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas')
@section('namePage', isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</h4>
                        </div>

                        <form action="{{ isset($kelas) ? route('kelas.update', $kelas->id) : route('kelas.store') }}" method="POST">
                            @csrf
                            @if (isset($kelas))
                                @method('PUT')
                            @endif

                            <div class="mb-6">
                                <label for="tingkat_kelas" class="block font-medium text-sm text-gray-700 mb-2">Tingkat Kelas</label>
                                <select name="tingkat_kelas" id="tingkat_kelas" required
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                    <option value="">-- Pilih Tingkat --</option>
                                    @foreach (['10', '11', '12'] as $tingkat)
                                        <option value="{{ $tingkat }}"
                                            {{ old('tingkat_kelas', $kelas->tingkat_kelas ?? '') == $tingkat ? 'selected' : '' }}>
                                            {{ $tingkat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tingkat_kelas')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="id_jurusan" class="block font-medium text-sm text-gray-700 mb-2">Jurusan</label>
                                <select name="id_jurusan" id="id_jurusan" required
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-nama="{{ $jurusan->nama_jurusan }}"
                                            {{ old('id_jurusan', $kelas->id_jurusan ?? '') == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jurusan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="nama_kelas" class="block font-medium text-sm text-gray-700 mb-2">Nama Kelas (otomatis)</label>
                                <input type="text" name="nama_kelas" id="nama_kelas"
                                    value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 bg-gray-100 cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full" readonly>
                                <p class="text-xs text-gray-500 mt-1">Nama kelas akan dibuat otomatis saat disimpan.</p>
                            </div>

                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('kelas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($kelas) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('afterAppScripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tingkatSelect = document.getElementById('tingkat_kelas');
            const jurusanSelect = document.getElementById('id_jurusan');
            const namaKelasInput = document.getElementById('nama_kelas');

            function updatePreview() {
                const tingkat = tingkatSelect.value;
                const jurusanId = jurusanSelect.value;
                const jurusanOption = jurusanSelect.options[jurusanSelect.selectedIndex];
                const jurusan = jurusanOption ? jurusanOption.getAttribute('data-nama') : '';

                if (tingkat && jurusanId) {
                    // Check if we are in edit mode to avoid overwriting existing name immediately if desired, 
                    // or just let it update as logic dictates. 
                    // Current logic updates on any change.
                    fetch(`/kelas/count?tingkat=${tingkat}&jurusan=${jurusanId}`)
                        .then(res => res.json())
                        .then(data => {
                            // If editing, we might want to be careful? 
                            // But original logic just overwrites on change, so preserving that.
                            // Note: server side likely handles the actual unique name generation or duplicate checks.
                            // The user simplified logic here just previews.
                            namaKelasInput.value = `${tingkat} ${jurusan} ${data.count + 1}`;
                        });
                } else {
                    namaKelasInput.value = '';
                }
            }

            tingkatSelect.addEventListener('change', updatePreview);
            jurusanSelect.addEventListener('change', updatePreview);
        });
    </script>
@endsection
