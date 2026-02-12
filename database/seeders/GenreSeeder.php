<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Fantasy', 'description' => 'Worlds of magic and wonder'],
            ['name' => 'Science Fiction', 'description' => 'Futuristic technology and space adventures'],
            ['name' => 'Mystery', 'description' => 'Crime solving and detective stories'],
            ['name' => 'Romance', 'description' => 'Love and relationships'],
            ['name' => 'Thriller', 'description' => 'Suspenseful and gripping narratives'],
            ['name' => 'Horror', 'description' => 'Scary and frightening tales'],
            ['name' => 'Biography', 'description' => 'Life stories and memoirs'],
            ['name' => 'Self-Help', 'description' => 'Personal development books'],
            ['name' => 'Historical Fiction', 'description' => 'Stories set in historical periods'],
            ['name' => 'Young Adult', 'description' => 'Books targeted at teen readers'],
            ['name' => 'Non-Fiction', 'description' => 'Factual and educational books'],
            ['name' => 'Children', 'description' => 'Books for young children'],
        ];

        foreach ($genres as $genre) {
            $genre['slug'] = Str::slug($genre['name']);
            $genre['is_active'] = true;
            Genre::create($genre);
        }
    }
}
