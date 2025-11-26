@extends('layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Tambah User')
@section('namaPage', isset($user->id) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ isset($user->id) ? 'Edit User' : 'Tambah User' }}</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ isset($user->id) ? route('userguru.update', $user->id) : route('userguru.store') }}" method="POST">
                @csrf
                @if(isset($user->id)) @method('PUT') @endif

                {{-- Role: hanya guru & kurikulum --}}
                <div class="mb-3">
                    <label for="roleSelect" class="form-label">Role</label>
                    <select id="roleSelect" name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="kurikulum" {{ old('role', $user->role) == 'kurikulum' ? 'selected' : '' }}>Kurikulum (Guru)</option>
                        <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Pilih Guru (diambil dari $gurus) --}}
                <div id="guruSelectContainer" class="mb-3 d-none">
                    <label for="guruSelect" class="form-label">Pilih Guru</label>
                    <select id="guruSelect" name="role_id" class="form-select">
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($gurus as $g)
                            <option value="{{ $g->id }}" {{ old('role_id', $user->role_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }} ({{ $g->nip }})
                            </option>
                        @endforeach
                    </select>
                    @if ($gurus->isEmpty())
                        <div class="small text-danger mt-1">Semua guru sudah memiliki akun.</div>
                    @endif
                </div>

                {{-- Username otomatis --}}
                <div class="mb-3">
                    <label for="usernameInput" class="form-label">Username (Otomatis)</label>
                    <input id="usernameInput" type="text" name="username" class="form-control" readonly
                           value="{{ old('username', $user->username) }}" required>
                    @error('username') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Password + sensor on/off --}}
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Password {{ isset($user->id) ? '(kosongkan jika tidak ingin ubah)' : '' }}</label>
                    <div class="input-group">
                        <input id="passwordInput" type="password" name="password" class="form-control"
                               {{ isset($user->id) ? '' : 'required' }}>
                        <button id="togglePassBtn" class="btn btn-outline-secondary" type="button" title="Sembunyikan/Tampilkan">
                            <i id="togglePassIcon" class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('userguru.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">{{ isset($user->id) ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('afterAppScripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const roleSelect = document.getElementById('roleSelect');
        const guruContainer = document.getElementById('guruSelectContainer');
        const guruSelect = document.getElementById('guruSelect');
        const usernameInput = document.getElementById('usernameInput');

        const toggleBtn = document.getElementById('togglePassBtn');
        const passInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('togglePassIcon');

        function toggleGuruSelect() {
            const role = roleSelect.value;
            if (role === 'guru' || role === 'kurikulum') {
                guruContainer.classList.remove('d-none');
                if (!guruSelect.value) usernameInput.value = '';
                // generate username if a guru already selected
                if (guruSelect.value) generateUsername();
            } else {
                guruContainer.classList.add('d-none');
                guruSelect.value = '';
                usernameInput.value = '';
            }
        }

        async function generateUsername(){
            const role = roleSelect.value;
            const roleId = guruSelect.value;
            if (!role || !roleId) return;
            try {
                const url = "{{ route('userguru.generateUsername') }}?role=" + role + "&role_id=" + roleId;
                const res = await fetch(url);
                const data = await res.json();
                usernameInput.value = data.username || '';
            } catch (err) {
                console.error('Gagal generate username:', err);
            }
        }

        // toggle password visibility
        toggleBtn.addEventListener('click', function(){
            const type = passInput.type === 'password' ? 'text' : 'password';
            passInput.type = type;
            toggleIcon.className = (type === 'password') ? 'bi bi-eye' : 'bi bi-eye-slash';
        });

        roleSelect.addEventListener('change', toggleGuruSelect);
        guruSelect && guruSelect.addEventListener('change', generateUsername);

        // init state on load
        toggleGuruSelect();
    });
</script>
@endsection
