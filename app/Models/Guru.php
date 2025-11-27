<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'nip',
        'jenis_kelamin',
        'alamat',
        'poto',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'role_id')
            ->whereIn('role', ['guru', 'kurikulum']);
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'id_guru');
    }
}
