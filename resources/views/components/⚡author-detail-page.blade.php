<?php

use App\Models\Author;
use Livewire\Component;

new class extends Component
{
        public string $slug = '';
        public ?Author $author = null;

        public function mount(string $slug): void
        {
                $this->slug = $slug;
        $this->author = Author::query()
            ->with(['books.genreRelation', 'books.formatRelation'])
            ->where('slug', $slug)
            ->firstOrFail();
        }
};
?>

<main class="page-shell">
    <section class="section reveal author-detail-head">
        <p class="section-subtitle" style="margin:0 0 0.35rem;">
            <a href="{{ route('authors') }}">Authors</a> / <span>{{ $author->name }}</span>
        </p>
        <h1>{{ $author->name }}</h1>
        <p class="muted" style="max-width: 76ch;">{{ $author->bio }}</p>
        <div class="pill-row">
            <span class="pill">{{ $author->specialty }}</span>
            <span class="pill ghost">{{ $author->published_books }} published books</span>
        </div>
    </section>

    <div class="author-detail-layout">
        <aside class="section reveal author-detail-side">
            <div class="author-detail-profile">
                <div class="author-avatar">{{ strtoupper(substr($author->name, 0, 2)) }}</div>
                <div>
                    <h2 class="section-title">Author Profile</h2>
                    <p class="section-subtitle" style="margin:.2rem 0 0;">{{ $author->city }}</p>
                </div>
            </div>

            <ul class="author-fact-list">
                <li class="author-fact">
                    <span>Followers</span>
                    <strong>{{ $author->followers_count }}</strong>
                </li>
                <li class="author-fact">
                    <span>Main Focus</span>
                    <strong>{{ $author->specialty }}</strong>
                </li>
            </ul>

            <p class="author-detail-quote">{{ $author->quote }}</p>

            <div class="pill-row">
                <a class="button" href="{{ route('store') }}">Explore Store</a>
            </div>
        </aside>

        <section class="section reveal author-detail-main">
            <h2 class="section-title">Reader Insights</h2>
            <p class="section-subtitle">What readers can expect from this author’s writing style and themes.</p>

            <div class="grid cols-3 author-insight-grid">
                <article class="card">
                    <h3>Writing Style</h3>
                    <p class="muted" style="margin:0;">Clear narrative with practical, immersive, and character-led storytelling.</p>
                </article>
                <article class="card">
                    <h3>Best For</h3>
                    <p class="muted" style="margin:0;">Readers seeking depth, consistency, and genre-driven discovery.</p>
                </article>
                <article class="card">
                    <h3>Catalog Strength</h3>
                    <p class="muted" style="margin:0;">Balanced mix of latest releases and established audience favorites.</p>
                </article>
            </div>
        </section>
    </div>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">Books by {{ $author->name }}</h2>
                <p class="section-subtitle">Titles currently available in the BookNest catalog.</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Browse Full Catalog</a>
        </div>
        <div class="grid cols-4">
            @foreach ($author->books as $book)
                <article class="card">
                    <div class="book-cover" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                        {{ $book->genreRelation?->name ?? $book->genre }}
                    </div>
                    <h3>{{ $book->title }}</h3>
                    <p class="muted">${{ number_format($book->price, 2) }}</p>
                    <a class="button secondary" href="{{ route('book.detail', ['slug' => $book->slug]) }}">View Details</a>
                </article>
            @endforeach
        </div>
    </section>
</main>