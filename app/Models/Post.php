<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'body',
        'published_at',
    ];

    // Añadir casting para published_at
    protected $casts = [
        'published_at' => 'datetime', // Esto asegura que published_at se maneje como una fecha.
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votedUsers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
