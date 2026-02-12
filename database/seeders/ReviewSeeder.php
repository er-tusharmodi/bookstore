<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();
        $customers = User::whereHas('roles', function ($q) {
            $q->where('name', 'customer');
        })->get();

        if ($customers->isEmpty()) {
            $customers = User::where('email', 'customer@booknest.test')->get();
        }

        $reviews = [
            [
                'title' => 'Absolutely magical!',
                'comment' => 'This book is a masterpiece. Couldn\'t put it down and read it in one sitting. Highly recommended!',
                'rating' => 5,
            ],
            [
                'title' => 'Great read',
                'comment' => 'Really enjoyed this. The plot was engaging and the characters were well-developed.',
                'rating' => 4,
            ],
            [
                'title' => 'Not bad',
                'comment' => 'It was okay. Some parts were interesting but others dragged on.',
                'rating' => 3,
            ],
            [
                'title' => 'Disappointed',
                'comment' => 'Expected more from this book. The ending was unsatisfying.',
                'rating' => 2,
            ],
            [
                'title' => 'Exceptional work',
                'comment' => 'This is the best book I\'ve read this year. The author really knows how to tell a story.',
                'rating' => 5,
            ],
            [
                'title' => 'Very good',
                'comment' => 'Loved the pacing and the plot twists. Definitely worth reading.',
                'rating' => 4,
            ],
            [
                'title' => 'Average',
                'comment' => 'It was fine but nothing exceptional. Good for passing time.',
                'rating' => 3,
            ],
            [
                'title' => 'Mind-blowing',
                'comment' => 'This book completely changed my perspective. Philosophical and thought-provoking.',
                'rating' => 5,
            ],
        ];

        for ($i = 0; $i < 30; $i++) {
            $review = $reviews[$i % count($reviews)];

            Review::create([
                'book_id' => $books->random()->id,
                'user_id' => $customers->count() > 0 ? $customers->random()->id : User::first()->id,
                'title' => $review['title'],
                'comment' => $review['comment'],
                'rating' => $review['rating'],
                'is_approved' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(0, 90)),
            ]);
        }
    }
}
