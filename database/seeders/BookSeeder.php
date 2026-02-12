<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Format;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'blurb' => 'The first book in the Harry Potter series, following a young wizard\'s journey.',
                'price' => 14.99,
                'author_id' => 1,
                'genre_id' => 1,  // Fantasy
                'format_id' => 1, // Hardcover
                'published_year' => 1997,
                'rating' => 4.9,
            ],
            [
                'title' => 'A Game of Thrones',
                'blurb' => 'Epic fantasy novel of power, intrigue, and dragons.',
                'price' => 19.99,
                'author_id' => 2,
                'genre_id' => 1,  // Fantasy
                'format_id' => 1, // Hardcover
                'published_year' => 1996,
                'rating' => 4.8,
            ],
            [
                'title' => 'The Shining',
                'blurb' => 'A psychological horror novel about a family isolated in a haunted hotel.',
                'price' => 16.99,
                'author_id' => 3,
                'genre_id' => 6,  // Horror
                'format_id' => 2, // Paperback
                'published_year' => 1977,
                'rating' => 4.6,
            ],
            [
                'title' => 'The Fellowship of the Ring',
                'blurb' => 'The beginning of an epic quest to save Middle-earth.',
                'price' => 18.99,
                'author_id' => 4,
                'genre_id' => 1,  // Fantasy
                'format_id' => 1, // Hardcover
                'published_year' => 1954,
                'rating' => 4.9,
            ],
            [
                'title' => 'Murder on the Orient Express',
                'blurb' => 'Agatha Christie\'s classic mystery novel.',
                'price' => 12.99,
                'author_id' => 5,
                'genre_id' => 3,  // Mystery
                'format_id' => 2, // Paperback
                'published_year' => 1934,
                'rating' => 4.7,
            ],
            [
                'title' => 'Foundation',
                'blurb' => 'A groundbreaking science fiction epic about the fall and rise of civilization.',
                'price' => 15.99,
                'author_id' => 6,
                'genre_id' => 2,  // Science Fiction
                'format_id' => 3, // E-Book
                'published_year' => 1951,
                'rating' => 4.8,
            ],
            [
                'title' => '2001: A Space Odyssey',
                'blurb' => 'A visionary science fiction masterpiece about space exploration.',
                'price' => 17.99,
                'author_id' => 7,
                'genre_id' => 2,  // Science Fiction
                'format_id' => 1, // Hardcover
                'published_year' => 1968,
                'rating' => 4.7,
            ],
            [
                'title' => 'Pride and Prejudice',
                'blurb' => 'Classic romance novel exploring love and society.',
                'price' => 11.99,
                'author_id' => 8,
                'genre_id' => 4,  // Romance
                'format_id' => 2, // Paperback
                'published_year' => 1813,
                'rating' => 4.8,
            ],
            [
                'title' => 'The Alchemist',
                'blurb' => 'A philosophical adventure about following your dreams.',
                'price' => 13.99,
                'author_id' => 9,
                'genre_id' => 8,  // Self-Help
                'format_id' => 2, // Paperback
                'published_year' => 1988,
                'rating' => 4.5,
            ],
            [
                'title' => 'The Handmaid\'s Tale',
                'blurb' => 'A dystopian novel about oppression and resistance.',
                'price' => 17.99,
                'author_id' => 10,
                'genre_id' => 2,  // Science Fiction
                'format_id' => 3, // E-Book
                'published_year' => 1985,
                'rating' => 4.7,
            ],
            [
                'title' => 'Dune',
                'blurb' => 'Epic space opera about politics and survival on a desert planet.',
                'price' => 18.99,
                'author_id' => 1,
                'genre_id' => 2,  // Science Fiction
                'format_id' => 4, // Audiobook
                'published_year' => 1965,
                'rating' => 4.9,
            ],
            [
                'title' => 'The Great Gatsby',
                'blurb' => 'Classic American novel about wealth and love in the Jazz Age.',
                'price' => 12.99,
                'author_id' => 2,
                'genre_id' => 4,  // Romance
                'format_id' => 2, // Paperback
                'published_year' => 1925,
                'rating' => 4.6,
            ],
        ];

        foreach ($books as $bookData) {
            $bookData['slug'] = Str::slug($bookData['title']);
            Book::create($bookData);
        }
    }
}
