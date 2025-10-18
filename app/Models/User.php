<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'role',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi ke model sesuai role_id
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'role_id');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'role_id');
    }
}
