@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('namaPage', 'Daftar Guru')

@section('content')
    <div class="max-w-6xl mx-auto mt-0 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Data Guru</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-3">
            <a href="{{ route('guru.create') }}"
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
                        <th class="py-3 px-4 text-left border-b">NIP</th>
                        <th class="py-3 px-4 text-left border-b">Jenis Kelamin</th>
                        <th class="py-3 px-4 text-left border-b">Dibuat Pada</th>
                        <th class="py-3 px-4 text-center border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guru as $index => $g)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">
                                {{ $loop->iteration + ($guru->currentPage() - 1) * $guru->perPage() }}</td>
                            <td class="py-3 px-4 border-b">{{ $g->nama }}</td>
                            <td class="py-3 px-4 border-b">{{ $g->nip }}</td>
                            <td class="py-3 px-4 border-b">{{ $g->jenis_kelamin }}</td>
                            <td class="py-3 px-4 border-b">{{ $g->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 border-b text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('guru.edit', $g->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('guru.destroy', $g->id) }}" method="POST"
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
                            <td colspan="6" class="text-center text-gray-500 py-5 italic">Tidak ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $guru->links() }}
        </div>
    </div>
@endsection