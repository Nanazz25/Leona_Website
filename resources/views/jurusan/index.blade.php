@extends('layouts.app')
@section('content')
    <div class="p-6">

        {{-- Tombol Tambah --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Jurusan</h1>
            <a href="{{ route('jurusan.create') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">
                Tambahkan Data
            </a>
        </div>

        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Data --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Jurusan</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusans as $index => $jurusan)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $jurusans->firstItem() + $index }}</td>
                            <td class="py-3 px-4">{{ $jurusan->nama_jurusan }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('jurusan.edit', $jurusan->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data jurusan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jurusans->links() }}
        </div>

    </div>
@endsection