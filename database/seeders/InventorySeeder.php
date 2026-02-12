<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Store;
use App\Models\Book;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();
        $books = Book::all();

        foreach ($stores as $store) {
            foreach ($books as $book) {
                Inventory::create([
                    'store_id' => $store->id,
                    'book_id' => $book->id,
                    'sku' => 'SKU-' . $store->id . '-' . str_pad($book->id, 4, '0', STR_PAD_LEFT),
                    'quantity' => rand(5, 50),
                    'price' => $book->price + rand(-5, 10), // Slight price variation per store
                    'reorder_level' => 5,
                    'status' => 'active',
                ]);
            }
        }
    }
}
