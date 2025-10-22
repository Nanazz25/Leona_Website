@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-12 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-8">
            {{ isset($murid) ? 'Edit Data Murid' : 'Tambah Data Murid' }}
        </h2>

        <form action="{{ isset($murid) ? route('murid.update', $murid->id) : route('murid.store') }}" method="POST"
            class="space-y-6">
            @csrf
            @if(isset($murid))
                @method('PUT')
            @endif

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Murid</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $murid->nama ?? '') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NISN -->
            <div>
                <label for="nisn" class="block text-gray-700 font-semibold mb-2">NISN</label>
                <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $murid->nisn ?? '') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                @error('nisn')
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
                    <option value="Laki-laki" {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="id_kelas" class="block text-gray-700 font-semibold mb-2">Kelas</label>
                <select id="id_kelas" name="id_kelas"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('id_kelas', $murid->id_kelas ?? '') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-between items-center pt-4">
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-semibold shadow transition duration-200">
                    {{ isset($murid) ? 'Perbarui Data' : 'Simpan Data' }}
                </button>

                <a href="{{ route('murid.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold shadow transition duration-200">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection