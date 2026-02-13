<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'specialty',
        'city',
        'followers_count',
        'published_books',
        'quote',
        'bio',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'author_user')->withTimestamps();
    }
}
