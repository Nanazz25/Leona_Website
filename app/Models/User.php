<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
     * Relasi dinamis ke model sesuai role
     */
    public function roleable()
    {
        return match ($this->role) {
            'guru', 'kurikulum' => $this->belongsTo(Guru::class, 'role_id'),
            'murid' => $this->belongsTo(Murid::class, 'role_id'),
            default => null,
        };
    }

    // Kalau ingin akses cepat tanpa if-else di controller:
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'role_id');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'role_id');
    }
}
