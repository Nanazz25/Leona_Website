<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'judul',
        'deskripsi',
        'start_time',
        'end_time',
        'created_by',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'created_by');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'quiz_kelas', 'id_quiz', 'id_kelas');
    }

    public function soal()
    {
        return $this->hasMany(QuizSoal::class, 'id_quiz');
    }

    public function nilai()
    {
        return $this->hasMany(QuizNilai::class, 'id_quiz');
    }
}

