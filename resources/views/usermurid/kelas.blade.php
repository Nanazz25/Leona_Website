@extends('layouts.app')

@section('title', 'User Murid - Pilih Kelas')
@section('namaPage', 'User Murid')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="{{ route('usermurid.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
                    <i class="bi bi-arrow-left mr-2"></i> Kembali
                </a>
                <span class="text-xl font-bold text-gray-800">Kelas di Jurusan {{ $jurusan->nama_jurusan }}</span>
            </div>
            
            <form method="GET" action="{{ route('usermurid.kelas', $jurusan->id) }}" class="flex">
                <input type="text" name="search" value="{{ $search }}" class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Cari kelas...">
                <button class="bg-white border border-l-0 border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-r-md text-sm font-medium">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="font-bold text-lg mb-4">Daftar Kelas - {{ $jurusan->nama_jurusan }}</div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Murid</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($kelas as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + $kelas->firstItem() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_kelas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->murid_count }} Murid</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('usermurid.murid', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full transition-colors duration-200">
                                            Lihat Murid
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data kelas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $kelas->links() }}
        </div>

    </div>

@endsection
