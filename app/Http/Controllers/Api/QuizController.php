<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        Quiz::where('end_time', '<', now())
            ->where('is_archived', false)
            ->update(['is_archived' => true]);

        $user = $request->user();
        $status = $request->query('status'); // aktif | archived | belum_dikerjakan

        $query = Quiz::with(['kelas', 'soal.bankSoal']);

        // === FILTER STATUS ARSIP ===
        if ($status === 'archived') {
            $query->where('is_archived', true);
        } else {
            $query->where('is_archived', false);
        }

        // === ROLE FILTERING ===
        if ($user->role === 'murid') {

            $query->whereHas('kelas.murid', function ($q) use ($user) {
                $q->where('id', $user->role_id);
            });

            // kalau murid ingin lihat yang belum dikerjakan
            if ($status === 'belum_dikerjakan') {
                $query->whereDoesntHave('nilai', function ($q) use ($user) {
                    $q->where('id_murid', $user->role_id);
                });
            }

        } elseif ($user->role === 'guru') {
            $query->where('created_by', $user->role_id);

        } elseif ($user->role === 'kurikulum') {
            // semua quiz
        }

        $quiz = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Daftar quiz berhasil diambil',
            'status_filter' => $status,
            'total' => $quiz->count(),
            'data' => $quiz
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::with(['kelas', 'soal.bankSoal'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail quiz berhasil diambil',
            'data' => $quiz
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $user = $request->user();

        // Hanya guru atau kurikulum yang bisa buat quiz
        if (!in_array($user->role, ['guru', 'kurikulum'])) {
            return response()->json(['message' => 'Hanya guru atau kurikulum yang dapat membuat quiz'], 403);
        }

        $guru = Guru::find($user->role_id);
        if (!$guru) {
            return response()->json(['message' => 'Data guru tidak ditemukan'], 404);
        }

        $quiz = Quiz::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'created_by' => $guru->id,
            'is_archived' => false,
        ]);

        return response()->json([
            'message' => 'Quiz berhasil dibuat',
            'data' => $quiz
        ], 201);
    }

    public function assignKelas(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required|array',
            'kelas.*' => 'exists:kelas,id',
        ]);

        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        // Guru hanya bisa ubah quiz miliknya, kurikulum bebas
        if ($user->role === 'guru' && $quiz->created_by !== $user->role_id) {
            return response()->json(['message' => 'Tidak diizinkan mengubah quiz guru lain'], 403);
        }

        $quiz->kelas()->sync($request->kelas);

        return response()->json([
            'message' => 'Kelas berhasil dihubungkan dengan quiz',
            'quiz_id' => $quiz->id,
            'kelas' => $request->kelas
        ]);
    }

    public function assignSoal(Request $request, $id)
    {
        $request->validate([
            'soal' => 'required|array',
            'soal.*.id_bank_soal' => 'required|exists:bank_soal,id',
            'soal.*.point' => 'required|integer|min:1'
        ]);

        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        // Guru hanya bisa ubah quiz miliknya, kurikulum bebas
        if ($user->role === 'guru' && $quiz->created_by !== $user->role_id) {
            return response()->json(['message' => 'Tidak diizinkan mengubah quiz guru lain'], 403);
        }

        // Reset soal lama
        $quiz->soal()->delete();

        foreach ($request->soal as $item) {
            $quiz->soal()->create([
                'id_bank_soal' => $item['id_bank_soal'],
                'point' => $item['point']
            ]);
        }

        return response()->json([
            'message' => 'Soal berhasil ditambahkan ke quiz',
            'quiz_id' => $quiz->id,
            'total_soal' => count($request->soal)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
        ]);

        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        // Guru hanya boleh update quiz miliknya, kurikulum bebas
        if ($user->role === 'guru' && $quiz->created_by !== $user->role_id) {
            return response()->json(['message' => 'Tidak diizinkan mengubah quiz guru lain'], 403);
        }

        // Update data dasar
        $quiz->update($request->only(['judul', 'deskripsi', 'start_time', 'end_time']));

        // Otomatis ubah status arsip kalau waktu berubah
        if ($quiz->end_time && now()->lt($quiz->end_time)) {
            $quiz->is_archived = false; // aktif kembali
        } else {
            $quiz->is_archived = true; // tetap arsip kalau waktunya sudah lewat
        }

        $quiz->save();

        return response()->json([
            'message' => 'Quiz berhasil diperbarui',
            'data' => $quiz
        ]);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        // Guru hanya bisa hapus quiz miliknya, kurikulum bisa hapus semua
        if ($user->role === 'guru' && $quiz->created_by !== $user->role_id) {
            return response()->json(['message' => 'Tidak diizinkan menghapus quiz guru lain'], 403);
        }

        // Cek apakah sudah ada siswa yang mengerjakan
        $sudahDikerjakan = DB::table('jawaban_quiz')
            ->where('id_quiz', $quiz->id)
            ->exists();

        if ($sudahDikerjakan) {
            $quiz->update(['is_archived' => true]);
            return response()->json([
                'message' => 'Quiz sudah pernah dikerjakan, dialihkan ke arsip',
                'quiz_id' => $quiz->id
            ]);
        }

        DB::transaction(function () use ($quiz) {
            $quiz->kelas()->detach();
            $quiz->soal()->delete();

            DB::table('quiz_nilai')->where('id_quiz', $quiz->id)->delete();
            DB::table('jawaban_quiz')->where('id_quiz', $quiz->id)->delete();

            $quiz->delete();
        });

        return response()->json(['message' => 'Quiz berhasil dihapus beserta relasinya']);
    }
}
