<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'tingkat_kelas',
        'id_jurusan',
        'nama_kelas',
    ];


    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }


    public function murid()
    {
        return $this->hasMany(Murid::class, 'id_kelas');
    }


    public function mataPelajaranKelas()
    {
        return $this->hasMany(MataPelajaranKelas::class, 'id_kelas');
    }
}
