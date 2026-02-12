<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'spotlight_book_id',
        'featured_book_ids',
        'more_book_ids',
        'featured_author_ids',
        'stats_books',
        'stats_authors',
        'stats_genres',
    ];

    protected $casts = [
        'featured_book_ids' => 'array',
        'more_book_ids' => 'array',
        'featured_author_ids' => 'array',
    ];

    public function spotlightBook()
    {
        return $this->belongsTo(Book::class, 'spotlight_book_id');
    }
}
