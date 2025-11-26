@extends('layouts.app')

@section('title', 'User Guru')
@section('namaPage', 'User Guru')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">User Guru & Kurikulum</h3>
            <div>
                <a href="{{ route('userguru.form') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input id="searchInput" type="text" class="form-control"
                    placeholder="Cari username atau nama (mis. muthia)">
            </div>
        </div>

        <!-- Table -->
        <!-- Table -->
        <div class="table-responsive">
            <table id="usersTable" class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No.</th>
                        <th>Role User</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                                <tr>
                                    <td>{{ $users->firstItem() + $i }}</td>

                                    <!-- ROLE USER -->
                                    <td>{{ $u->role ?? '-' }}</td>

                                    <td class="username-cell">{{ $u->username }}</td>

                                    <!-- Nama diambil dari relasi guru atau kurikulum -->
                                    <td class="name-cell">
                                        {{ optional($u->guru)->nama
                        ?? optional($u->kurikulum)->nama
                        ?? '-' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('userguru.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('userguru.destroy', $u->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus user?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Jika ingin pagination server-side: tampilkan link dari salah satu paginasi -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                {{-- Tampilkan info total jika tersedia --}}
                @if(isset($guruUsers) || isset($kurikulumUsers))
                    <small class="text-muted">
                        Menampilkan
                        {{ ($guruUsers ? $guruUsers->count() : 0) + ($kurikulumUsers ? $kurikulumUsers->count() : 0) }}
                        entri
                    </small>
                @endif
            </div>

            <div>
                {{-- Jika Anda ingin pagination, Anda bisa pilih salah satu pagination set:
                misal: {{ $guruUsers->links() }} atau gabungkan logic pagination di controller.
                Di sini tidak otomatis menampilkan pagination gabungan. --}}
            </div>
        </div>
    </div>
@endsection

@section('afterAppScripts')
    <!-- Pastikan Bootstrap Icons tersedia; kalau layouts.app belum load, Anda bisa tambahkan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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