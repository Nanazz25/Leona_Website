<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizNilai;
use App\Models\Quiz;
use App\Models\JawabanQuiz;
use App\Models\QuizSoal;
use Illuminate\Support\Facades\Auth;

class QuizNilaiController extends Controller
{
    public function calculate($id_quiz)
    {
        $quiz = Quiz::findOrFail($id_quiz);

        // Ambil semua murid yang sudah menjawab
        $muridIds = JawabanQuiz::where('id_quiz', $id_quiz)
            ->pluck('id_murid')
            ->unique();

        // Total point maksimum quiz
        $maxPoint = QuizSoal::where('id_quiz', $id_quiz)->sum('point');

        // Hitung ulang nilai untuk setiap murid
        foreach ($muridIds as $id_murid) {

            // Total point murid ini
            $totalPoint = JawabanQuiz::where('id_quiz', $id_quiz)
                ->where('id_murid', $id_murid)
                ->sum('point_didapat');

            // Skor skala 100
            $score = $maxPoint > 0
                ? ($totalPoint / $maxPoint) * 100
                : 0;

            // Simpan atau perbarui nilai
            QuizNilai::updateOrCreate(
                [
                    'id_quiz' => $id_quiz,
                    'id_murid' => $id_murid,
                ],
                [
                    'total_point' => round($score, 2),
                    'max_point' => 100,
                    'dikerjakan_pada' => now(),
                ]
            );
        }

        return response()->json([
            'message' => 'Nilai quiz berhasil dihitung ulang',
            'total_murid' => $muridIds->count()
        ]);
    }

    public function show($id_quiz)
    {
        $user = Auth::user();

        // Ambil nilai quiz
        $query = QuizNilai::with('murid')->where('id_quiz', $id_quiz);

        // Murid hanya boleh lihat nilainya sendiri
        if ($user->role === 'murid') {
            $query->where('id_murid', $user->role_id);
        }

        // Guru dan Kurikulum boleh lihat semua nilai
        $nilai = $query->get();

        return response()->json([
            'message' => 'Nilai quiz berhasil diambil',
            'total' => $nilai->count(),
            'data' => $nilai
        ]);
    }
}
