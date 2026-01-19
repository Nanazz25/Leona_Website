@extends('layouts.app')

@section('title', isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan')
@section('namePage', isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan' }}</h4>
                        </div>

                        <form action="{{ isset($jurusan) ? route('jurusan.update', $jurusan->id) : route('jurusan.store') }}" method="POST">
                            @csrf
                            @if(isset($jurusan))
                                @method('PUT')
                            @endif

                            <div class="mb-6">
                                <label for="nama_jurusan" class="block font-medium text-sm text-gray-700 mb-2">Nama Jurusan</label>
                                <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    required>
                                @error('nama_jurusan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('jurusan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($jurusan) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
