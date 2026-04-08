<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'client';

    protected $fillable = ['nom', 'prenom', 'telephone', 'email', 'adresse', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
