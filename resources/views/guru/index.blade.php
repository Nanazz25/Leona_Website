@extends('layouts.app')

@section('title', 'Daftar Guru')
@section('namaPage', 'Daftar Guru')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
             <h4 class="text-xl font-bold text-gray-800">Data Guru</h4>
             <div class="flex gap-2">
                <a href="{{ route('guru.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200">
                    <i class="bi bi-plus-lg"></i> Tambah Guru
                </a>
             </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="GET" action="{{ route('guru.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-4">
                    <!-- Search Name -->
                    <div class="col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama guru..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </div>

                    <!-- Date Range Start -->
                    <div class="col-span-1">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </div>

                    <!-- Date Range End -->
                    <div class="col-span-1">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                    </div>

                    <!-- Buttons -->
                    <div class="col-span-1 flex gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200 w-full">
                            Filter
                        </button>
                        <a href="{{ route('guru.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200 w-full text-center">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Pada</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($guru as $index => $g)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration + ($guru->currentPage() - 1) * $guru->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $g->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $g->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $g->jenis_kelamin }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $g->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('guru.edit', $g->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-md transition-colors duration-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('guru.destroy', $g->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-colors duration-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $guru->links() }}
        </div>

    </div>
@endsection