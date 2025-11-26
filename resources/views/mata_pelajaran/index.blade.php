@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')

@section('namePage', 'Daftar Mata Pelajaran')

@section('content')
    <div class="p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Mata Pelajaran</h1>
            <a href="{{ route('mata_pelajaran.create') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">
                Tambahkan Data
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Mata Pelajaran</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Guru</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $index => $m)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $mapel->firstItem() + $index }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $m->nama_pelajaran }}</td>

                            {{-- Kolom Kelas --}}
                            <td class="py-3 px-4">
                                @if($m->kelas && $m->kelas->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($m->kelas as $k)
                                            <span class="bg-purple-600 text-white rounded-full px-3 py-1 text-xs font-semibold">
                                                {{ $k->tingkat_kelas }} {{ $k->jurusan->nama_jurusan ?? '' }} {{ $k->nama_kelas }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Belum ada kelas</span>
                                @endif
                            </td>

                            {{-- Kolom Guru --}}
                            <td class="py-3 px-4">
                                @if($m->guru && $m->guru->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($m->guru as $g)
                                            <span class="bg-blue-500 text-white rounded-full px-3 py-1 text-xs font-semibold">
                                                {{ $g->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Belum ada guru</span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('mata_pelajaran.edit', $m->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('mata_pelajaran.destroy', $m->id) }}" method="POST"
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
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data mata pelajaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $mapel->links() }}
        </div>

    </div>
@endsection