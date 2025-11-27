<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserGuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('guru')
            ->whereIn('role', ['guru', 'kurikulum'])
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'LIKE', "%$search%")
                    ->orWhereHas(
                        'guru',
                        fn($q) =>
                        $q->where('nama', 'LIKE', "%$search%")
                    );
            })
            ->latest()
            ->paginate(20);

        return view('userguru.index', compact('users', 'search'));
    }

    public function form($id = null)
    {
        $user = $id ? User::findOrFail($id) : new User;

        // ID guru yang sudah punya akun
        $usedGuruIds = User::whereIn('role', ['guru', 'kurikulum'])
            ->where('id', '!=', $id)
            ->pluck('role_id')
            ->toArray();

        $gurus = Guru::whereNotIn('id', $usedGuruIds)->get();

        return view('userguru.form', compact('user', 'gurus'));
    }

    public function generateUsername(Request $request)
    {
        $role = $request->role;
        $roleId = $request->role_id;

        if (!$role || !$roleId) {
            return response()->json(['username' => null]);
        }

        $guru = Guru::find($roleId);
        if (!$guru) return response()->json(['username' => null]);

        $nama = strtoupper(Str::slug(Str::words($guru->nama, 1, ''), ''));

        // angka random 3 digit
        $rand = rand(100, 999);

        $prefix = $role === 'guru' ? 'GUR' : 'KUR';

        return response()->json([
            'username' => "{$prefix}-{$nama}{$rand}"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:guru,kurikulum',
            'role_id' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('userguru.index')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:guru,kurikulum',
            'role_id' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'role' => $request->role,
            'role_id' => $request->role_id,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        return redirect()->route('userguru.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('userguru.index')->with('success', 'User berhasil dihapus');
    }
}
