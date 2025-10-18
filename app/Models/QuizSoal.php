<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSoal extends Model
{
    use HasFactory;

    protected $table = 'quiz_soal';

    protected $fillable = [
        'id_quiz',
        'id_bank_soal',
        'point',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class, 'id_bank_soal');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanQuiz::class, 'id_quiz_soal');
    }
}
