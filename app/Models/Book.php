<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'genre',
        'format',
        'genre_id',
        'format_id',
        'price',
        'published_year',
        'rating',
        'blurb',
        'cover_tone',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_deal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_deal' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genreRelation()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function formatRelation()
    {
        return $this->belongsTo(Format::class, 'format_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistEntries()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
