<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizNilai extends Model
{
    use HasFactory;

    protected $table = 'quiz_nilai';

    protected $fillable = [
        'id_quiz',
        'id_murid',
        'total_point',
        'max_point',
        'dikerjakan_pada',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
}
