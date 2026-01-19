@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')
@section('namaPage', 'Daftar Mata Pelajaran')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
             <h4 class="text-xl font-bold text-gray-800">Daftar Mata Pelajaran</h4>
             <div class="flex gap-2">
                <a href="{{ route('mata_pelajaran.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200">
                    <i class="bi bi-plus-lg"></i> Tambahkan Data
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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mata Pelajaran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($mapel as $index => $m)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $mapel->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $m->nama_pelajaran }}</td>

                                    {{-- Kolom Kelas --}}
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($m->kelas && $m->kelas->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($m->kelas as $k)
                                                    <span class="bg-indigo-100 text-indigo-800 rounded-full px-2 py-0.5 text-xs font-medium">
                                                        {{ $k->tingkat_kelas }} {{ $k->jurusan->nama_jurusan ?? '' }} {{ $k->nama_kelas }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Belum ada kelas</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Guru --}}
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($m->guru && $m->guru->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($m->guru as $g)
                                                    <span class="bg-blue-100 text-blue-800 rounded-full px-2 py-0.5 text-xs font-medium">
                                                        {{ $g->nama }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Belum ada guru</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('mata_pelajaran.edit', $m->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-md transition-colors duration-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('mata_pelajaran.destroy', $m->id) }}" method="POST"
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
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data mata pelajaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $mapel->links() }}
        </div>

    </div>
@endsection