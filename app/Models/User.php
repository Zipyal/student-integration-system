<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'curator_id'
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

    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                   ->withPivot('confirmed')
                   ->withTimestamps();
    }
}