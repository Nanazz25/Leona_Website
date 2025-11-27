<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        // Ambil user beserta data detailnya (guru/murid)
        // Ambil user
        $user = $request->user();

        // Load data detail manual karena 'roleable' bukan relationship standar Eloquent
        if (in_array($user->role, ['guru', 'kurikulum'])) {
            $user->load('guru');
            // Attach data guru ke atribut 'roleable' agar format response konsisten (opsional)
            $user->setRelation('roleable', $user->guru);
        } elseif ($user->role === 'murid') {
            $user->load('murid.kelas');
            $user->setRelation('roleable', $user->murid);
        }

        return response()->json([
            'message' => 'Profile berhasil diambil',
            'data' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        // Validasi umum
        $rules = [
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string',
            'poto' => 'nullable|image|max:2048', // Max 2MB
            'password' => 'nullable|min:6|confirmed', // password_confirmation required
        ];

        $request->validate($rules);

        // 1. Update User (Email & Password)
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 2. Update Detail (Guru/Murid)
        $detail = null;
        if (in_array($user->role, ['guru', 'kurikulum'])) {
            $detail = $user->guru;
        } elseif ($user->role === 'murid') {
            $detail = $user->murid;
        }

        if ($detail) {
            if ($request->has('alamat')) {
                $detail->alamat = $request->alamat;
            }

            // Handle Upload Foto
            if ($request->hasFile('poto')) {
                // Hapus foto lama jika ada (opsional, cek dulu apakah bukan default)
                if ($detail->poto && Storage::exists('public/' . $detail->poto)) {
                    Storage::delete('public/' . $detail->poto);
                }

                // Simpan foto baru
                $path = $request->file('poto')->store('profile_photos', 'public');
                $detail->poto = $path;
            }

            $detail->save();
        }

        // Refresh data untuk response
        if (in_array($user->role, ['guru', 'kurikulum'])) {
            $user->load('guru');
            $user->setRelation('roleable', $user->guru);
        } elseif ($user->role === 'murid') {
            $user->load('murid');
            $user->setRelation('roleable', $user->murid);
        }

        return response()->json([
            'message' => 'Profile berhasil diperbarui',
            'data' => $user
        ]);
    }
}
