<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Murid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['guru', 'murid'])->latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User();

        // Ambil semua id guru & murid yang sudah punya user (dipastikan integer)
        $usedGuruIds = User::whereIn('role', ['guru', 'kurikulum'])
            ->pluck('role_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        $usedMuridIds = User::where('role', 'murid')
            ->pluck('role_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        // Ambil hanya guru & murid yang belum punya user
        $gurus = Guru::whereNotIn('id', $usedGuruIds)->select('id', 'nama', 'nip')->get();
        $murids = Murid::whereNotIn('id', $usedMuridIds)->select('id', 'nama', 'nisn')->get();

        return view('user.form', compact('user', 'gurus', 'murids'));
    }

    public function getRoleData(Request $request)
    {
        $role = $request->role;

        if (in_array($role, ['guru', 'kurikulum'])) {
            $usedGuruIds = User::whereIn('role', ['guru', 'kurikulum'])
                ->pluck('role_id')
                ->map(fn($id) => (int) $id)
                ->toArray();

            $data = Guru::whereNotIn('id', $usedGuruIds)
                ->select('id', 'nama')
                ->get();
        } elseif ($role === 'murid') {
            $usedMuridIds = User::where('role', 'murid')
                ->pluck('role_id')
                ->map(fn($id) => (int) $id)
                ->toArray();

            $data = Murid::whereNotIn('id', $usedMuridIds)
                ->select('id', 'nama')
                ->get();
        } else {
            $data = collect();
        }

        return response()->json($data);
    }

    public function generateUsername(Request $request)
    {
        $prefix = match ($request->role) {
            'guru' => 'GUR',
            'kurikulum' => 'KUR',
            'murid' => 'MUR',
            default => null,
        };

        if (!$prefix || !$request->role_id) {
            return response()->json(['username' => null]);
        }

        if (in_array($request->role, ['guru', 'kurikulum'])) {
            $guru = Guru::find($request->role_id);
            if (!$guru) return response()->json(['username' => null]);

            $namaDepan = strtoupper(Str::slug(Str::words($guru->nama, 1, ''), ''));
            $kodeAkhir = substr($guru->nip, -3);
        } else {
            $murid = Murid::find($request->role_id);
            if (!$murid) return response()->json(['username' => null]);

            $namaDepan = strtoupper(Str::slug(Str::words($murid->nama, 1, ''), ''));
            $kodeAkhir = substr($murid->nisn, -3);
        }

        $username = "{$prefix}-{$namaDepan}{$kodeAkhir}";
        return response()->json(['username' => $username]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:kurikulum,guru,murid',
            'role_id' => 'required|integer',
            'password' => 'required|string|min:6',
        ]);

        $prefix = match ($request->role) {
            'guru' => 'GUR',
            'kurikulum' => 'KUR',
            'murid' => 'MUR',
            default => null,
        };

        if (in_array($request->role, ['guru', 'kurikulum'])) {
            $roleModel = Guru::findOrFail($request->role_id);
            $namaDepan = strtoupper(Str::slug(Str::words($roleModel->nama, 1, ''), ''));
            $kodeAkhir = substr($roleModel->nip, -3);
        } else {
            $roleModel = Murid::findOrFail($request->role_id);
            $namaDepan = strtoupper(Str::slug(Str::words($roleModel->nama, 1, ''), ''));
            $kodeAkhir = substr($roleModel->nisn, -3);
        }

        $username = "{$prefix}-{$namaDepan}{$kodeAkhir}";

        if (User::where('username', $username)->exists()) {
            return back()
                ->withErrors(['username' => '❌ User dengan username ini sudah ada.'])
                ->withInput();
        }

        User::create([
            'username' => $username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'role_id' => $roleModel->id,
        ]);

        return redirect()->route('user.index')->with('success', '✅ User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $usedGuruIds = User::whereIn('role', ['guru', 'kurikulum'])
            ->where('id', '!=', $id)
            ->pluck('role_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        $usedMuridIds = User::where('role', 'murid')
            ->where('id', '!=', $id)
            ->pluck('role_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        $gurus = Guru::whereNotIn('id', $usedGuruIds)->select('id', 'nama', 'nip')->get();
        $murids = Murid::whereNotIn('id', $usedMuridIds)->select('id', 'nama', 'nisn')->get();

        return view('user.form', compact('user', 'gurus', 'murids'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:kurikulum,guru,murid',
            'role_id' => 'required|integer',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id);

        $prefix = match ($request->role) {
            'guru' => 'GUR',
            'kurikulum' => 'KUR',
            'murid' => 'MUR',
            default => null,
        };

        if (in_array($request->role, ['guru', 'kurikulum'])) {
            $roleModel = Guru::findOrFail($request->role_id);
            $namaDepan = strtoupper(Str::slug(Str::words($roleModel->nama, 1, ''), ''));
            $kodeAkhir = substr($roleModel->nip, -3);
        } else {
            $roleModel = Murid::findOrFail($request->role_id);
            $namaDepan = strtoupper(Str::slug(Str::words($roleModel->nama, 1, ''), ''));
            $kodeAkhir = substr($roleModel->nisn, -3);
        }

        $username = "{$prefix}-{$namaDepan}{$kodeAkhir}";

        $user->update([
            'role' => $request->role,
            'role_id' => $request->role_id,
            'username' => $username,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', '✅ Data user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', '🗑️ User berhasil dihapus.');
    }
}
