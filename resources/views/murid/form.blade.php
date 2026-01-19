@extends('layouts.app')

@section('title', isset($murid) ? 'Edit Murid' : 'Tambah Murid')
@section('namaPage', isset($murid) ? 'Edit Murid' : 'Tambah Murid')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($murid) ? 'Edit Data Murid' : 'Tambah Data Murid' }}</h4>
                             <p class="text-gray-500 text-sm mt-1">Silakan isi form berikut dengan data yang valid.</p>
                        </div>

                        <form method="POST" action="{{ isset($murid) ? route('murid.update', $murid->id) : route('murid.store') }}">
                            @csrf
                            @if(isset($murid))
                                @method('PUT')
                            @endif

                            <div class="mb-6">
                                <label for="nama" class="block font-medium text-sm text-gray-700 mb-2">Nama Murid</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $murid->nama ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                @error('nama')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="nisn" class="block font-medium text-sm text-gray-700 mb-2">NISN</label>
                                <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $murid->nisn ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 bg-gray-100 cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    readonly required>
                                <p class="text-gray-500 text-xs mt-1">NISN otomatis digenerate sistem.</p>
                                @error('nisn')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="jenis_kelamin" class="block font-medium text-sm text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="id_kelas" class="block font-medium text-sm text-gray-700 mb-2">Kelas</label>
                                <select name="id_kelas" id="id_kelas"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('id_kelas', $murid->id_kelas ?? '') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kelas')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('murid.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($murid) ? 'Perbarui Data' : 'Simpan Data' }}
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
        const nisnInput = document.getElementById('nisn');
        if (!nisnInput.value) {
            // Generate 16 digit random number
            let randomNisn = '';
            for (let i = 0; i < 16; i++) {
                randomNisn += Math.floor(Math.random() * 10);
            }
            nisnInput.value = randomNisn;
        }
    });
</script>
@endsection
