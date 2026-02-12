<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'store_id',
        'book_id',
        'sku',
        'quantity',
        'price',
        'reorder_level',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
