@extends('layouts.app')
@section('content')
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            {{ isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan' }}
        </h1>

        {{-- Form --}}
        <form action="{{ isset($jurusan) ? route('jurusan.update', $jurusan->id) : route('jurusan.store') }}" method="POST"
            class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @csrf
            @if(isset($jurusan))
                @method('PUT')
            @endif

            <div>
                <label class="block text-gray-700 mb-1">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    required>
                @error('nama_jurusan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('jurusan.index') }}" class="text-gray-600 hover:text-gray-800 transition">← Kembali</a>

                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">
                    {{ isset($jurusan) ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>

    </div>
@endsection