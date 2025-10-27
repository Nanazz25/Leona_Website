<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanQuiz;
use App\Models\Quiz;
use App\Models\QuizSoal;
use App\Models\QuizNilai;
use Illuminate\Support\Facades\Auth;

class JawabanQuizController extends Controller
{
    /**
     * Kirim jawaban siswa untuk 1 soal quiz.
     */
    public function store(Request $request, $id_quiz)
    {
        $request->validate([
            'id_quiz_soal' => 'required|exists:quiz_soal,id',
            'jawaban_siswa' => 'required|in:A,B,C,D',
        ]);

        $user = Auth::user();
        $id_murid = $user->role_id;

        $quiz = Quiz::findOrFail($id_quiz);

        // Pastikan quiz masih aktif
        if ($quiz->is_archived || now()->gt($quiz->end_time)) {
            return response()->json(['message' => 'Quiz sudah berakhir'], 403);
        }

        $quizSoal = QuizSoal::with('bankSoal')->findOrFail($request->id_quiz_soal);

        // Pastikan soal benar-benar milik quiz ini
        if ($quizSoal->id_quiz != $quiz->id) {
            return response()->json(['message' => 'Soal tidak termasuk dalam quiz ini'], 422);
        }

        // Cegah jawaban ganda
        $existing = JawabanQuiz::where('id_quiz', $id_quiz)
            ->where('id_quiz_soal', $quizSoal->id)
            ->where('id_murid', $id_murid)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Kamu sudah menjawab soal ini',
                'data' => $existing
            ], 409); // Conflict
        }

        // Cek benar/salah
        $jawabanBenar = strtoupper($quizSoal->bankSoal->jawaban_benar);
        $benar = ($request->jawaban_siswa === $jawabanBenar);
        $point = $benar ? $quizSoal->point : 0;

        // Simpan jawaban baru
        $jawaban = JawabanQuiz::create([
            'id_quiz' => $id_quiz,
            'id_quiz_soal' => $quizSoal->id,
            'id_murid' => $id_murid,
            'jawaban_siswa' => $request->jawaban_siswa,
            'benar' => $benar,
            'point_didapat' => $point,
        ]);

        // Hitung ulang nilai total
        $totalPoint = JawabanQuiz::where('id_quiz', $id_quiz)
            ->where('id_murid', $id_murid)
            ->sum('point_didapat');

        $maxPoint = QuizSoal::where('id_quiz', $id_quiz)->sum('point');

        QuizNilai::updateOrCreate(
            [
                'id_quiz' => $id_quiz,
                'id_murid' => $id_murid,
            ],
            [
                'total_point' => $totalPoint,
                'max_point' => $maxPoint,
                'dikerjakan_pada' => now(),
            ]
        );

        return response()->json([
            'message' => 'Jawaban berhasil disimpan',
            'data' => [
                'jawaban' => $jawaban,
                'benar' => $benar,
                'point_didapat' => $point,
                'total_point' => $totalPoint,
                'max_point' => $maxPoint,
            ]
        ]);
    }

    /**
     * Lihat semua jawaban siswa untuk quiz tertentu.
     */
    public function show($id_quiz)
    {
        $user = Auth::user();
        $id_murid = $user->role_id;

        $jawaban = JawabanQuiz::with('quizSoal.bankSoal')
            ->where('id_quiz', $id_quiz)
            ->where('id_murid', $id_murid)
            ->get();

        return response()->json([
            'message' => 'Daftar jawaban berhasil diambil',
            'total' => $jawaban->count(),
            'data' => $jawaban
        ]);
    }
}
