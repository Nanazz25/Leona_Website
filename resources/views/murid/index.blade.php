@extends('layouts.app')

@section('title', 'Daftar Murid')

@section('namaPage', 'Daftar Murid')

@section('content')
    <div class="max-w-6xl mx-auto mt-0 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Data Murid</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <form method="GET" action="{{ route('murid.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <!-- Search Name -->
                <div class="col-span-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama murid..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm">
                </div>

                <!-- Filter Class -->
                <div class="col-span-1">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Kelas</label>
                    <select name="kelas_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Start -->
                <div class="col-span-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm">
                </div>

                <!-- Date Range End -->
                <div class="col-span-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm">
                </div>

                <!-- Buttons -->
                <div class="col-span-1 flex gap-2">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200 w-full">
                        Filter
                    </button>
                    <a href="{{ route('murid.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200 w-full text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="flex justify-end mb-3">
            <a href="{{ route('murid.create') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-200">
                + Tambahkan Data
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="py-3 px-4 text-left border-b">No</th>
                        <th class="py-3 px-4 text-left border-b">Nama</th>
                        <th class="py-3 px-4 text-left border-b">NISN</th>
                        <th class="py-3 px-4 text-left border-b">Jenis Kelamin</th>
                        <th class="py-3 px-4 text-left border-b">Kelas</th>
                        <th class="py-3 px-4 text-left border-b">Dibuat Pada</th>
                        <th class="py-3 px-4 text-center border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($murid as $index => $m)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">
                                {{ $loop->iteration + ($murid->currentPage() - 1) * $murid->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $m->nama }}</td>
                            <td class="py-3 px-4 border-b">{{ $m->nisn }}</td>
                            <td class="py-3 px-4 border-b">{{ $m->jenis_kelamin }}</td>
                            <td class="py-3 px-4 border-b">{{ $m->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-3 px-4 border-b">{{ $m->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 border-b text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('murid.edit', $m->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('murid.destroy', $m->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-5 italic">Tidak ada data murid.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $murid->links() }}
        </div>
    </div>
@endsection
