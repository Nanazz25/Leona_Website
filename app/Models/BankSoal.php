<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory;

    protected $table = 'bank_soal';

    protected $fillable = [
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'id_kategori_soal',
        'created_by',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSoal::class, 'id_kategori_soal');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'created_by');
    }

    public function quizSoal()
    {
        return $this->hasMany(QuizSoal::class, 'id_soal');
    }
}
