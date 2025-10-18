<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaranGuru extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran_guru';

    protected $fillable = [
        'id_guru',
        'id_mata_pelajaran',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }
}
