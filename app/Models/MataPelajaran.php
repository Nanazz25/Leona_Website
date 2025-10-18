<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_pelajaran',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'mata_pelajaran_kelas', 'id_mata_pelajaran', 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'mata_pelajaran_guru', 'id_mata_pelajaran', 'id_guru');
    }

    public function bankSoal()
    {
        return $this->hasMany(BankSoal::class, 'id_mata_pelajaran');
    }
}
