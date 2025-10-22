@extends('layouts.app')

@section('title', isset($guru) ? 'Edit Guru' : 'Tambah Guru')

@section('namaPage', isset($guru) ? 'Edit Guru' : 'Tambah Guru')

@section('content')
    <div class="max-w-lg mx-auto mt-12 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-8">
            {{ isset($guru) ? 'Edit Data Guru' : 'Tambah Data Guru' }}
        </h2>

        <form action="{{ isset($guru) ? route('guru.update', $guru->id) : route('guru.store') }}" method="POST"
            class="space-y-6">
            @csrf
            @if(isset($guru))
                @method('PUT')
            @endif

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Guru</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $guru->nama ?? '') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIP -->
            <div>
                <label for="nip" class="block text-gray-700 font-semibold mb-2">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip ?? '') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-between items-center pt-4">
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-semibold shadow transition duration-200">
                    {{ isset($guru) ? 'Perbarui Data' : 'Simpan Data' }}
                </button>

                <a href="{{ route('guru.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold shadow transition duration-200">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
