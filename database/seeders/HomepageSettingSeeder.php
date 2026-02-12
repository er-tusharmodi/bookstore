<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\HomepageSetting;
use Illuminate\Database\Seeder;

class HomepageSettingSeeder extends Seeder
{
    /**
     * Seed the homepage settings.
     */
    public function run(): void
    {
        $spotlightBook = Book::query()->latest()->first();
        $featuredBooks = Book::query()->orderByDesc('rating')->limit(4)->pluck('id')->all();
        $moreBooks = Book::query()->latest()->limit(8)->pluck('id')->all();
        $featuredAuthors = Author::query()->orderByDesc('followers_count')->limit(6)->pluck('id')->all();

        $payload = [
            'hero_title' => 'Book Spotlight Deck',
            'hero_subtitle' => 'Use thumbnails to switch featured books instantly.',
            'spotlight_book_id' => $spotlightBook?->id,
            'featured_book_ids' => $featuredBooks,
            'more_book_ids' => $moreBooks,
            'featured_author_ids' => $featuredAuthors,
            'stats_books' => Book::count(),
            'stats_authors' => Author::count(),
            'stats_genres' => Genre::count(),
        ];

        $existing = HomepageSetting::query()->latest()->first();

        if ($existing) {
            $existing->update($payload);
            return;
        }

        HomepageSetting::query()->create($payload);
    }
}
