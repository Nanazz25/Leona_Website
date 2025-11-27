<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserMuridController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $jurusan = \App\Models\Jurusan::withCount('kelas')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_jurusan', 'LIKE', "%$search%");
            })
            ->paginate(20);

        return view('usermurid.index', compact('jurusan', 'search'));
    }

    public function kelas(Request $request, $jurusanId)
    {
        $jurusan = \App\Models\Jurusan::findOrFail($jurusanId);
        $search = $request->search;
        
        $kelas = \App\Models\Kelas::where('id_jurusan', $jurusanId)
            ->withCount('murid')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_kelas', 'LIKE', "%$search%");
            })
            ->paginate(20);

        return view('usermurid.kelas', compact('jurusan', 'kelas', 'search'));
    }

    public function murid(Request $request, $kelasId)
    {
        $kelas = \App\Models\Kelas::with('jurusan')->findOrFail($kelasId);
        $search = $request->search;

        $murid = \App\Models\Murid::where('id_kelas', $kelasId)
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%")
                      ->orWhere('nisn', 'LIKE', "%$search%");
            })
            ->paginate(20);

        return view('usermurid.murid', compact('kelas', 'murid', 'search'));
    }

    public function form($kelasId, $id = null)
    {
        $kelas = \App\Models\Kelas::with('jurusan')->findOrFail($kelasId);
        // If editing, find the UserMurid (User model)
        $user = $id ? User::with('murid')->findOrFail($id) : null;
        
        // If we have a user, we get the murid data from the relation
        $murid = $user ? $user->murid : null;

        return view('usermurid.form', compact('kelas', 'user', 'murid'));
    }

    public function searchMurid(Request $request)
    {
        $query = $request->get('q');
        $excludeUserId = $request->get('exclude_user_id'); // If editing, allow current murid

        $murids = Murid::whereDoesntHave('user', function($q) use ($excludeUserId) {
                $q->where('role', 'murid');
                if ($excludeUserId) {
                    $q->where('id', '!=', $excludeUserId);
                }
            })
            ->where(function($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('nisn', 'LIKE', "%{$query}%");
            })
            ->with(['kelas.jurusan'])
            ->limit(20)
            ->get();

        return response()->json($murids->map(function($m) {
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'nisn' => $m->nisn,
                'kelas_nama' => $m->kelas->nama_kelas ?? '-',
                'jurusan_nama' => $m->kelas->jurusan->nama_jurusan ?? '-',
                'text' => $m->nama . ' - ' . $m->nisn // Helper for frontend
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'murid_id' => 'required|exists:murid,id|unique:users,role_id,NULL,id,role,murid', // Ensure unique role_id for role=murid
            'password' => 'required|min:6',
        ]);

        $murid = Murid::findOrFail($request->murid_id);

        // Generate Username
        $namaSlug = strtoupper(Str::slug(Str::words($murid->nama, 1, ''), ''));
        $nisnSub = substr($murid->nisn, -3); // Last 3 digits
        $username = "MUR-{$namaSlug}{$nisnSub}";
        
        // Ensure username uniqueness
        if (User::where('username', $username)->exists()) {
            $username .= rand(10, 99);
        }

        User::create([
            'username' => $username,
            'role' => 'murid',
            'role_id' => $murid->id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usermurid.murid', $murid->id_kelas)
            ->with('success', "User murid berhasil ditambahkan. Username: $username");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'murid_id' => 'required|exists:murid,id',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        
        // Check if murid_id is being changed and if the new one is already taken
        if ($user->role_id != $request->murid_id) {
            $exists = User::where('role', 'murid')
                ->where('role_id', $request->murid_id)
                ->where('id', '!=', $id)
                ->exists();
            
            if ($exists) {
                return back()->withErrors(['murid_id' => 'Murid ini sudah memiliki akun user.']);
            }
        }

        $murid = Murid::findOrFail($request->murid_id);
        
        // Update User
        $updateData = [
            'role_id' => $murid->id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Optional: Regenerate username if murid changes?
        // User didn't explicitly ask to regenerate username on edit, but it might be good practice if the person changes completely.
        // However, usually username is constant. Let's keep it constant unless requested otherwise to avoid confusion.
        
        $user->update($updateData);

        return redirect()->route('usermurid.murid', $murid->id_kelas)
            ->with('success', 'Data user murid berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Get class ID for redirect
        $kelasId = null;
        if ($user->role === 'murid' && $user->role_id) {
            $murid = Murid::find($user->role_id);
            if ($murid) {
                $kelasId = $murid->id_kelas;
            }
        }

        $user->delete();

        if ($kelasId) {
            return redirect()->route('usermurid.murid', $kelasId)
                ->with('success', 'User murid berhasil dihapus');
        }

        return redirect()->route('usermurid.index')
            ->with('success', 'User murid berhasil dihapus');
    }
}
