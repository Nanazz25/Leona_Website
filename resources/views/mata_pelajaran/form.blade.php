@extends('layouts.app')
@section('content')
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            {{ isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
        </h1>

        <form
            action="{{ isset($mata_pelajaran) ? route('mata_pelajaran.update', $mata_pelajaran->id) : route('mata_pelajaran.store') }}"
            method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @csrf
            @if(isset($mata_pelajaran))
                @method('PUT')
            @endif

            {{-- Nama Mata Pelajaran --}}
            <div>
                <label class="block text-gray-700 mb-1">Nama Mata Pelajaran</label>
                <input type="text" name="nama_pelajaran"
                    value="{{ old('nama_pelajaran', $mata_pelajaran->nama_pelajaran ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    required>
                @error('nama_pelajaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('mata_pelajaran.index') }}" class="text-gray-600 hover:text-gray-800 transition">←
                    Kembali</a>

                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">
                    {{ isset($mata_pelajaran) ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
@endsection