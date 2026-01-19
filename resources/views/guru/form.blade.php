@extends('layouts.app')

@section('title', isset($guru) ? 'Edit Guru' : 'Tambah Guru')
@section('namaPage', isset($guru) ? 'Edit Guru' : 'Tambah Guru')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($guru) ? 'Edit Data Guru' : 'Tambah Data Guru' }}</h4>
                             <p class="text-gray-500 text-sm mt-1">Silakan isi form berikut dengan data yang valid.</p>
                        </div>

                        <form method="POST" action="{{ isset($guru) ? route('guru.update', $guru->id) : route('guru.store') }}">
                            @csrf
                            @if(isset($guru))
                                @method('PUT')
                            @endif

                            <div class="mb-6">
                                <label for="nama" class="block font-medium text-sm text-gray-700 mb-2">Nama Guru</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $guru->nama ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                @error('nama')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="nip" class="block font-medium text-sm text-gray-700 mb-2">NIP</label>
                                <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 bg-gray-100 cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    readonly required>
                                <p class="text-gray-500 text-xs mt-1">NIP otomatis digenerate sistem.</p>
                                @error('nip')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="jenis_kelamin" class="block font-medium text-sm text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('guru.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($guru) ? 'Perbarui Data' : 'Simpan Data' }}
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
    document.addEventListener('DOMContentLoaded', function() {
        const nipInput = document.getElementById('nip');
        if (!nipInput.value) {
            // Generate 16 digit random number
            let randomNip = '';
            for (let i = 0; i < 16; i++) {
                randomNip += Math.floor(Math.random() * 10);
            }
            nipInput.value = randomNip;
        }
    });
</script>
@endsection
