@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        {{ isset($user->id) ? 'Edit User' : 'Tambah User' }}
    </h1>

    <form action="{{ isset($user->id) ? route('user.update', $user->id) : route('user.store') }}" method="POST" class="space-y-5">
        @csrf
        @if(isset($user->id))
            @method('PUT')
        @endif

        {{-- Username --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
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

        {{-- Role --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Role</label>
            <select name="role"
                    class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
                <option value="">-- Pilih Role --</option>
                <option value="kurikulum" {{ old('role', $user->role) == 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="murid" {{ old('role', $user->role) == 'murid' ? 'selected' : '' }}>Murid</option>
            </select>
            @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role ID --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Role ID (Opsional)</label>
            <input type="number" name="role_id" value="{{ old('role_id', $user->role_id) }}"
                   class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('user.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
               Kembali
            </a>
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                {{ isset($user->id) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
