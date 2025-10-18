<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;

    protected $table = 'absensi_detail';

    protected $fillable = [
        'id_absensi',
        'id_murid',
        'kehadiran',
        'keterangan',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
}
