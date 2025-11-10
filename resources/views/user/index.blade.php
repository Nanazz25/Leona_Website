@extends('layouts.app')

@section('title', 'Daftar User')
@section('namaPage', 'Daftar User')

@section('content')
    <div class="max-w-7xl mx-auto mt-0 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Data User</h2>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol tambah --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('user.create') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-200">
                + Tambahkan Data
            </a>
        </div>

        {{-- ======== TABEL KURIKULUM ======== --}}
        <div class="mb-10">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Tabel Kurikulum</h3>
            <input type="text" id="searchKurikulum" placeholder="Cari user kurikulum..."
                class="w-full mb-3 p-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg tabel-user">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left border-b">No</th>
                            <th class="py-3 px-4 text-left border-b">Username</th>
                            <th class="py-3 px-4 text-left border-b">Nama</th>
                            <th class="py-3 px-4 text-center border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyKurikulum">
                        @php $no = ($kurikulumUsers->currentPage() - 1) * $kurikulumUsers->perPage() + 1; @endphp
                        @forelse ($kurikulumUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $no++ }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->username }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->guru->nama ?? '-' }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-semibold">Edit</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4 italic">Tidak ada user kurikulum.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Kurikulum --}}
            @if ($kurikulumUsers->hasPages())
                <div class="mt-4">
                    {{ $kurikulumUsers->links() }}
                </div>
            @endif
        </div>

        {{-- ======== TABEL GURU ======== --}}
        <div class="mb-10">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Tabel Guru</h3>
            <input type="text" id="searchGuru" placeholder="Cari user guru..."
                class="w-full mb-3 p-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg tabel-user">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left border-b">No</th>
                            <th class="py-3 px-4 text-left border-b">Username</th>
                            <th class="py-3 px-4 text-left border-b">Nama</th>
                            <th class="py-3 px-4 text-center border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyGuru">
                        @php $no = ($guruUsers->currentPage() - 1) * $guruUsers->perPage() + 1; @endphp
                        @forelse ($guruUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $no++ }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->username }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->guru->nama ?? '-' }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-semibold">Edit</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4 italic">Tidak ada user guru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Guru --}}
            @if ($guruUsers->hasPages())
                <div class="mt-4">
                    {{ $guruUsers->links() }}
                </div>
            @endif
        </div>

        {{-- ======== TABEL MURID ======== --}}
        <div class="mb-10">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Tabel Murid</h3>
            <input type="text" id="searchMurid" placeholder="Cari user murid..."
                class="w-full mb-3 p-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg tabel-user">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left border-b">No</th>
                            <th class="py-3 px-4 text-left border-b">Username</th>
                            <th class="py-3 px-4 text-left border-b">Nama</th>
                            <th class="py-3 px-4 text-center border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyMurid">
                        @php $no = ($muridUsers->currentPage() - 1) * $muridUsers->perPage() + 1; @endphp
                        @forelse ($muridUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $no++ }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->username }}</td>
                                <td class="py-3 px-4 border-b">{{ $user->murid->nama ?? '-' }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-semibold">Edit</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4 italic">Tidak ada user murid.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Murid --}}
            @if ($muridUsers->hasPages())
                <div class="mt-4">
                    {{ $muridUsers->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ======== SCRIPT SEARCH PER TABEL ======== --}}
    <script>
        function setupSearch(inputId, tableId) {
            const input = document.getElementById(inputId);
            input.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll(`#${tableId} tr`);
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        }

        setupSearch('searchKurikulum', 'tbodyKurikulum');
        setupSearch('searchGuru', 'tbodyGuru');
        setupSearch('searchMurid', 'tbodyMurid');
    </script>
@endsection