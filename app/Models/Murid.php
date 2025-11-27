<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'murid';

    protected $fillable = [
        'nama',
        'nisn',
        'jenis_kelamin',
        'id_kelas',
        'alamat',
        'poto',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'role_id')
            ->where('role', 'murid');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function quizNilai()
    {
        return $this->hasMany(QuizNilai::class, 'id_murid');
    }
}
