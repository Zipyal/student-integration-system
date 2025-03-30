<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'curator_id',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Отношения
    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'curator_id');
    }

    // Проверка ролей
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCurator()
    {
        return $this->role === 'curator';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}