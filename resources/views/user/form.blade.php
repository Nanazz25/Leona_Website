@extends('layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Tambah User')
@section('namaPage', isset($user->id) ? 'Edit User' : 'Tambah User')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            {{ isset($user->id) ? 'Edit User' : 'Tambah User' }}
        </h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ isset($user->id) ? route('user.update', $user->id) : route('user.store') }}" method="POST"
            class="space-y-5">
            @csrf
            @if (isset($user->id))
                @method('PUT')
            @endif

            {{-- Role --}}
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Role</label>
                <select id="roleSelect" name="role"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    required>
                    <option value="">-- Pilih Role --</option>
                    <option value="kurikulum" {{ old('role', $user->role) == 'kurikulum' ? 'selected' : '' }}>Kurikulum
                        (Guru)</option>
                    <option value="guru" {{ old('role', optional($user)->role) == 'guru' ? 'selected' : '' }}>Guru
                    </option>
                    <option value="murid" {{ old('role', $user->role) == 'murid' ? 'selected' : '' }}>Murid</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilih Guru --}}
            <div id="guruSelectContainer" class="hidden">
                <label class="block font-semibold mb-1 text-gray-700">Pilih Guru</label>
                <select id="guruSelect" name="role_id"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}"
                            {{ old('role_id', $user->role_id) == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }} ({{ $guru->nip }})
                        </option>
                    @endforeach
                </select>
                @if ($gurus->isEmpty())
                    <p class="text-sm text-red-500 mt-1">Semua guru sudah memiliki akun.</p>
                @endif
            </div>

            {{-- Pilih Murid --}}
            <div id="muridSelectContainer" class="hidden">
                <label class="block font-semibold mb-1 text-gray-700">Pilih Murid</label>
                <select id="muridSelect" name="role_id"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">-- Pilih Murid --</option>
                    @foreach ($murids as $murid)
                        <option value="{{ $murid->id }}"
                            {{ old('role_id', $user->role_id) == $murid->id ? 'selected' : '' }}>
                            {{ $murid->nama }} ({{ $murid->nisn }})
                        </option>
                    @endforeach
                </select>
                @if ($murids->isEmpty())
                    <p class="text-sm text-red-500 mt-1">Semua murid sudah memiliki akun.</p>
                @endif
            </div>

            {{-- Username otomatis --}}
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Username (Otomatis)</label>
                <input type="text" id="usernameInput" name="username" value="{{ old('username', $user->username) }}"
                    class="w-full border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-600 focus:outline-none" readonly
                    required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    {{ isset($user->id) ? '' : 'required' }}>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('user.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                    Kembali
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                    {{ isset($user->id) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('afterAppScripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const guruContainer = document.getElementById('guruSelectContainer');
        const muridContainer = document.getElementById('muridSelectContainer');
        const usernameInput = document.getElementById('usernameInput');
        const guruSelect = document.getElementById('guruSelect');
        const muridSelect = document.getElementById('muridSelect');

        let guruTom = null;
        let muridTom = null;

        function initTomSelect(selector, placeholder) {
            // Hindari inisialisasi ganda
            const element = document.querySelector(selector);
            if (!element.tomselect) {
                return new TomSelect(selector, {
                    placeholder: placeholder,
                    maxOptions: 1000,
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    searchField: ["text"],
                    plugins: ['dropdown_input'],
                    render: {
                        option: (data, escape) =>
                            `<div class='px-2 py-1 hover:bg-purple-100 cursor-pointer text-gray-700'>${escape(data.text)}</div>`,
                        item: (data, escape) =>
                            `<div class='text-sm text-gray-700'>${escape(data.text)}</div>`
                    }
                });
            }
        }

        function toggleSelect() {
            const role = roleSelect.value;
            guruContainer.classList.add('hidden');
            muridContainer.classList.add('hidden');

            guruSelect.disabled = true;
            muridSelect.disabled = true;

            if (role === 'guru' || role === 'kurikulum') {
                guruContainer.classList.remove('hidden');
                guruSelect.disabled = false;

                // Inisialisasi Tom Select saat pertama kali tampil
                if (!guruTom) guruTom = initTomSelect("#guruSelect", "Cari guru berdasarkan nama atau NIP...");
            } else if (role === 'murid') {
                muridContainer.classList.remove('hidden');
                muridSelect.disabled = false;

                if (!muridTom) muridTom = initTomSelect("#muridSelect", "Cari murid berdasarkan nama atau NISN...");
            }

            usernameInput.value = '';
        }

        async function generateUsername() {
            const role = roleSelect.value;
            const roleId = (role === 'murid') ? muridSelect.value : guruSelect.value;
            if (!role || !roleId) return;

            try {
                const response = await fetch(`{{ route('user.generateUsername') }}?role=${role}&role_id=${roleId}`);
                const data = await response.json();
                usernameInput.value = data.username || '';
            } catch (err) {
                console.error('Gagal ambil username otomatis:', err);
            }
        }

        roleSelect.addEventListener('change', toggleSelect);
        guruSelect.addEventListener('change', generateUsername);
        muridSelect.addEventListener('change', generateUsername);

        document.addEventListener('DOMContentLoaded', toggleSelect);
    </script>
@endsection
