<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizKelas extends Model
{
    use HasFactory;

    protected $table = 'quiz_kelas';

    protected $fillable = [
        'id_quiz',
        'id_kelas',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
