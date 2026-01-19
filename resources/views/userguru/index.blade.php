@extends('layouts.app')

@section('title', 'User Guru')
@section('namaPage', 'User Guru')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h4 class="text-xl font-bold text-gray-800">User Guru & Kurikulum</h4>
            <div class="flex gap-2">
                <a href="{{ route('userguru.form') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow transition duration-200">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input id="searchInput" type="text" 
                    class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                    placeholder="Cari username atau nama (mis. muthia)">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $i => $u)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $users->firstItem() + $i }}
                                    </td>
                                    
                                    <!-- ROLE USER -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->role ?? '-' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 username-cell">{{ $u->username }}</td>

                                    <!-- Nama diambil dari relasi guru atau kurikulum -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 name-cell">
                                        {{ optional($u->guru)->nama ?? optional($u->kurikulum)->nama ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('userguru.edit', $u->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-md transition-colors duration-200">
                                                Edit
                                            </a>

                                            <form action="{{ route('userguru.destroy', $u->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-colors duration-200"
                                                    onclick="return confirm('Yakin hapus user?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div>
                @if(isset($guruUsers) || isset($kurikulumUsers))
                    <small class="text-gray-500">
                        Menampilkan
                        {{ ($guruUsers ? $guruUsers->count() : 0) + ($kurikulumUsers ? $kurikulumUsers->count() : 0) }}
                        entri
                    </small>
                @endif
            </div>

            <div>
                {{-- Pagination Links --}}
            </div>
        </div>
    </div>
@endsection

@section('afterAppScripts')
    <script>
        // Simple client-side search (filter baris berdasarkan username atau nama)
        (function () {
            const input = document.getElementById('searchInput');
            const table = document.getElementById('usersTable');
            const tbody = table.querySelector('tbody');

            input.addEventListener('input', function () {
                const q = this.value.trim().toLowerCase();
                const rows = tbody.querySelectorAll('tr');
                if (!q) {
                    rows.forEach(r => r.style.display = '');
                    return;
                }
                rows.forEach(r => {
                    const uname = (r.querySelector('.username-cell')?.textContent || '').toLowerCase();
                    const name = (r.querySelector('.name-cell')?.textContent || '').toLowerCase();
                    if (uname.includes(q) || name.includes(q)) {
                        r.style.display = '';
                    } else {
                        r.style.display = 'none';
                    }
                });
            });
        })();
    </script>
@endsection