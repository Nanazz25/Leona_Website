<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan semua user (urut terbaru + pagination)
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        // kirim objek kosong agar $user tidak undefined di view
        $user = new User();
        return view('user.form', compact('user'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:kurikulum,guru,murid',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user.index')->with('success', '✅ User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.form', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:kurikulum,guru,murid',
        ]);

        $user->update([
            'username' => $request->username,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user.index')->with('success', '✏️ User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', '🗑️ User berhasil dihapus.');
    }
}
