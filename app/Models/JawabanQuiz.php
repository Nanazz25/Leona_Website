<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanQuiz extends Model
{
    use HasFactory;

    protected $table = 'jawaban_quiz';

    protected $fillable = [
        'id_quiz',
        'id_quiz_soal',
        'id_murid',
        'jawaban_siswa',
        'benar',
        'point_didapat',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    public function quizSoal()
    {
        return $this->belongsTo(QuizSoal::class, 'id_quiz_soal');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
}
