<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaranKelas extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran_kelas';

    protected $fillable = [
        'id_mata_pelajaran',
        'id_kelas',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
