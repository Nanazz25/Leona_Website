<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoal extends Model
{
    use HasFactory;

    protected $table = 'kategori_soal';

    protected $fillable = [
        'nama',
    ];

    public function bankSoal()
    {
        return $this->hasMany(BankSoal::class, 'id_kategori');
    }
}
