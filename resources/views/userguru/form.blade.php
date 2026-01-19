@extends('layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Tambah User')
@section('namaPage', isset($user->id) ? 'Edit User' : 'Tambah User')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($user->id) ? 'Edit User' : 'Tambah User' }}</h4>
                        </div>

                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ isset($user->id) ? route('userguru.update', $user->id) : route('userguru.store') }}" method="POST">
                            @csrf
                            @if(isset($user->id)) @method('PUT') @endif

                            {{-- Role: hanya guru & kurikulum --}}
                            <div class="mb-6">
                                <label for="roleSelect" class="block font-medium text-sm text-gray-700 mb-2">Role</label>
                                <select id="roleSelect" name="role" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="kurikulum" {{ old('role', $user->role) == 'kurikulum' ? 'selected' : '' }}>Kurikulum (Guru)</option>
                                    <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                </select>
                                @error('role') <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Pilih Guru (diambil dari $gurus) --}}
                            <div id="guruSelectContainer" class="mb-6 hidden">
                                <label for="guruSelect" class="block font-medium text-sm text-gray-700 mb-2">Pilih Guru</label>
                                <select id="guruSelect" name="role_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $g)
                                        <option value="{{ $g->id }}" {{ old('role_id', $user->role_id) == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama }} ({{ $g->nip }})
                                        </option>
                                    @endforeach
                                </select>
                                @if ($gurus->isEmpty())
                                    <div class="text-red-500 text-xs mt-1">Semua guru sudah memiliki akun.</div>
                                @endif
                            </div>

                            {{-- Username otomatis --}}
                            <div class="mb-6">
                                <label for="usernameInput" class="block font-medium text-sm text-gray-700 mb-2">Username (Otomatis)</label>
                                <input id="usernameInput" type="text" name="username" readonly
                                    class="rounded-md shadow-sm border-gray-300 bg-gray-100 cursor-not-allowed focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    value="{{ old('username', $user->username) }}" required>
                                @error('username') <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Password + sensor on/off --}}
                            <div class="mb-6">
                                <label for="passwordInput" class="block font-medium text-sm text-gray-700 mb-2">Password {{ isset($user->id) ? '(kosongkan jika tidak ingin ubah)' : '' }}</label>
                                <div class="relative">
                                    <input id="passwordInput" type="password" name="password"
                                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full pr-10"
                                        {{ isset($user->id) ? '' : 'required' }}>
                                    <button id="togglePassBtn" type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none">
                                        <i id="togglePassIcon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password') <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tombol aksi --}}
                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('userguru.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($user->id) ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('afterAppScripts')
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
                guruContainer.classList.remove('hidden');
                if (!guruSelect.value) usernameInput.value = '';
                // generate username if a guru already selected
                if (guruSelect.value) generateUsername();
            } else {
                guruContainer.classList.add('hidden');
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
