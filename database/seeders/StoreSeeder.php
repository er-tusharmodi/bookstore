<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            ['name' => 'BookStore Center', 'email' => 'center@bookstore.com', 'phone' => '2125551234', 'address' => '123 Main St', 'city' => 'New York'],
            ['name' => 'Literary Corner', 'email' => 'corner@bookstore.com', 'phone' => '2135551234', 'address' => '456 Oak Ave', 'city' => 'Los Angeles'],
            ['name' => 'Page Turner Books', 'email' => 'pageturner@bookstore.com', 'phone' => '3125551234', 'address' => '789 Elm St', 'city' => 'Chicago'],
            ['name' => 'The Reading Room', 'email' => 'reading@bookstore.com', 'phone' => '7135551234', 'address' => '321 Pine St', 'city' => 'Houston'],
            ['name' => 'Bookworm Haven', 'email' => 'bookworm@bookstore.com', 'phone' => '6025551234', 'address' => '654 Maple Dr', 'city' => 'Phoenix'],
        ];

        foreach ($stores as $store) {
            $store['slug'] = Str::slug($store['name']);
            $store['status'] = 'active';
            Store::create($store);
        }
    }
}
