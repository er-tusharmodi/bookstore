<?php

namespace Database\Seeders;

use App\Models\Format;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormatSeeder extends Seeder
{
    public function run(): void
    {
        $formats = [
            ['name' => 'Hardcover', 'description' => 'Durable hardback binding'],
            ['name' => 'Paperback', 'description' => 'Flexible paperback binding'],
            ['name' => 'E-Book', 'description' => 'Digital book format'],
            ['name' => 'Audiobook', 'description' => 'Audio narration format'],
            ['name' => 'Comic Book', 'description' => 'Illustrated comic format'],
        ];

        foreach ($formats as $format) {
            $format['slug'] = Str::slug($format['name']);
            $format['is_active'] = true;
            Format::create($format);
        }
    }
}
