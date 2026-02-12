<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Seed pages data.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About',
                'slug' => 'about',
                'summary' => 'Learn how BookNest curates trusted reads for every reader.',
                'body' => '<p>BookNest is a modern bookstore focused on thoughtful curation. We help readers discover quality books quickly with clear filters, honest reviews, and curated collections.</p><p>Our team works with authors, publishers, and local stores to keep the catalog fresh and relevant.</p>',
                'meta_title' => 'About BookNest',
                'meta_description' => 'Learn about BookNest, our mission, and how we curate our catalog.',
                'meta_keywords' => 'about, bookstore, booknest',
            ],
            [
                'title' => 'Why Choose Us',
                'slug' => 'why-choose-us',
                'summary' => 'Discover what makes BookNest the easiest way to shop books online.',
                'body' => '<p>We focus on clarity, trust, and speed. Every book listing includes key details so you can decide quickly.</p><ul><li>Curated picks from top genres</li><li>Transparent pricing and ratings</li><li>Fast discovery with smart filters</li></ul>',
                'meta_title' => 'Why Choose BookNest',
                'meta_description' => 'See why readers choose BookNest for curated books and fast discovery.',
                'meta_keywords' => 'why choose, curated books, fast discovery',
            ],
            [
                'title' => 'Vision',
                'slug' => 'vision',
                'summary' => 'Our vision is to make book discovery calm and human-first.',
                'body' => '<p>We believe book discovery should feel calm and human. Our vision is to build the most trusted place to discover, compare, and collect books.</p><p>We continue to invest in author stories, clean design, and respectful recommendations.</p>',
                'meta_title' => 'BookNest Vision',
                'meta_description' => 'Read about the long-term vision for BookNest and our reader-first approach.',
                'meta_keywords' => 'vision, reader first, booknest',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'summary' => 'Review the terms that apply to using BookNest services.',
                'body' => '<p>By using BookNest, you agree to our terms regarding account use, purchases, and content. We may update these terms to improve clarity and service quality.</p><p>For questions, contact our support team using the email listed in the site settings.</p>',
                'meta_title' => 'BookNest Terms & Conditions',
                'meta_description' => 'Read the terms and conditions for using BookNest.',
                'meta_keywords' => 'terms, conditions, policy',
            ],
        ];

        foreach ($pages as $page) {
            Page::query()->updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'summary' => $page['summary'],
                    'body' => $page['body'],
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'meta_keywords' => $page['meta_keywords'],
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
        }
    }
}
