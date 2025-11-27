<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizNilai;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $muridId = null;

        // 1. Jika Murid, hanya bisa lihat punya sendiri
        if ($user->role === 'murid') {
            $muridId = $user->role_id;
        }
        // 2. Jika Guru/Kurikulum, bisa lihat punya murid tertentu (wajib kirim murid_id)
        else if (in_array($user->role, ['guru', 'kurikulum'])) {
            $request->validate([
                'murid_id' => 'required|exists:murid,id'
            ]);
            $muridId = $request->murid_id;
        }
        // 3. Role lain ditolak
        else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Ambil nilai quiz beserta info quiz-nya
        $nilai = QuizNilai::with(['quiz'])
            ->where('id_murid', $muridId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil rekap nilai',
            'role_pengakses' => $user->role,
            'murid_id' => $muridId,
            'data' => $nilai
        ]);
    }
}
