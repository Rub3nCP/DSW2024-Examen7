<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Obtener las publicaciones asociadas al usuario.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Obtener las publicaciones que el usuario ha votado.
     */
    public function votedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'votes');
    }
}
