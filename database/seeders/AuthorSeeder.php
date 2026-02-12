<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['name' => 'J.K. Rowling', 'specialty' => 'Fantasy', 'city' => 'London', 'bio' => 'British author known for Harry Potter series', 'quote' => 'It is impossible to live without failing at something'],
            ['name' => 'George R.R. Martin', 'specialty' => 'Fantasy', 'city' => 'New York', 'bio' => 'American novelist famous for A Song of Ice and Fire', 'quote' => 'A reader lives a thousand lives'],
            ['name' => 'Stephen King', 'specialty' => 'Horror', 'city' => 'Maine', 'bio' => 'Master of horror and suspense fiction', 'quote' => 'We make up horrors to help us cope with real ones'],
            ['name' => 'J.R.R. Tolkien', 'specialty' => 'Fantasy', 'city' => 'Oxford', 'bio' => 'Creator of Middle-earth and author of The Lord of the Rings', 'quote' => 'All we have to decide is what to do with the time that is given to us'],
            ['name' => 'Agatha Christie', 'specialty' => 'Mystery', 'city' => 'London', 'bio' => 'Queen of mystery fiction', 'quote' => 'The most important thing in life is making people happy'],
            ['name' => 'Isaac Asimov', 'specialty' => 'Science Fiction', 'city' => 'New York', 'bio' => 'Prolific science fiction author and scientist', 'quote' => 'Science is not only a disciple of reason but also of romance and passion'],
            ['name' => 'Arthur C. Clarke', 'specialty' => 'Science Fiction', 'city' => 'Sri Lanka', 'bio' => 'Visionary science fiction writer', 'quote' => 'Magic\'s just science that we don\'t understand yet'],
            ['name' => 'Jane Austen', 'specialty' => 'Romance', 'city' => 'Hampshire', 'bio' => 'English novelist known for romantic fiction', 'quote' => 'There is nothing I would not do for those who are really my friends'],
            ['name' => 'Paulo Coelho', 'specialty' => 'Philosophical', 'city' => 'Rio de Janeiro', 'bio' => 'Brazilian writer of philosophical fiction', 'quote' => 'If you want to be successful, you must respect one rule: Never lie to yourself'],
            ['name' => 'Margaret Atwood', 'specialty' => 'Science Fiction', 'city' => 'Toronto', 'bio' => 'Canadian author of speculative fiction', 'quote' => 'Wanting to be someone else is a waste of someone you are'],
        ];

        foreach ($authors as $author) {
            $author['slug'] = Str::slug($author['name']);
            Author::create($author);
        }
    }
}
