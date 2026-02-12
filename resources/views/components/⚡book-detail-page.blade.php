<?php

use App\Models\Book;
use Livewire\Component;

new class extends Component
{
    public string $slug = '';
    public ?Book $book = null;
    public $relatedBooks;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->book = Book::query()
            ->with(['author', 'genreRelation', 'formatRelation'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedQuery = Book::query()
            ->with(['author', 'genreRelation'])
            ->where('id', '!=', $this->book->id);

        if ($this->book->genre_id) {
            $relatedQuery->where('genre_id', $this->book->genre_id);
        } elseif ($this->book->genre) {
            $relatedQuery->where('genre', $this->book->genre);
        }

        $this->relatedBooks = $relatedQuery
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        if ($this->relatedBooks->isEmpty() && $this->book->author_id) {
            $this->relatedBooks = Book::query()
                ->with(['author', 'genreRelation'])
                ->where('author_id', $this->book->author_id)
                ->where('id', '!=', $this->book->id)
                ->limit(4)
                ->get();
        }
    }
};
?>

<main class="page-shell">
    <section class="hero reveal">
        <p class="section-subtitle" style="margin:0 0 0.35rem;">
            <a href="{{ route('store') }}">Store</a> / <span>{{ $book->title }}</span>
        </p>
        <h1>{{ $book->title }}</h1>
        <p class="muted" style="max-width: 72ch;">{{ $book->blurb }}</p>
    </section>

    <section class="section reveal detail-header">
        <article class="card">
            <div class="book-cover book-cover-large" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                {{ $book->genreRelation?->name ?? $book->genre }}
            </div>

            <div class="pill-row">
                <span class="pill">{{ $book->genreRelation?->name ?? $book->genre }}</span>
                <span class="pill ghost">{{ $book->formatRelation?->name ?? $book->format }}</span>
            </div>

            <div class="price-row">
                <strong>${{ number_format($book->price, 2) }}</strong>
                <span>Rating {{ number_format($book->rating, 1) }}</span>
            </div>

            <div class="product-actions">
                <button type="button" class="button secondary" data-book-id="{{ $book->id }}">Save</button>
                <button type="button" class="button" data-book-id="{{ $book->id }}">Add to Cart</button>
            </div>
        </article>

        <article class="hero">
            <h2 class="section-title">Book Information</h2>
            <ul class="list">
                <li>
                    Author:
                    <a href="{{ route('author.detail', ['slug' => $book->author?->slug]) }}">
                        {{ $book->author?->name ?? 'Author' }}
                    </a>
                </li>
                <li>Published year: <strong>{{ $book->published_year ?? '—' }}</strong></li>
                <li>Format: <strong>{{ $book->formatRelation?->name ?? $book->format ?? '—' }}</strong></li>
                <li>Genre: <strong>{{ $book->genreRelation?->name ?? $book->genre ?? '—' }}</strong></li>
            </ul>
            <a class="button secondary" href="{{ route('author.detail', ['slug' => $book->author?->slug]) }}">View Author Profile</a>
        </article>
    </section>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">Related Books</h2>
                <p class="section-subtitle">More titles you might like from this catalog.</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Back to Store</a>
        </div>
        <div class="grid cols-4">
            @forelse ($relatedBooks as $related)
                <article class="card">
                    <div class="book-cover" style="background: {{ $related->cover_tone ?? '#232f3e' }};">
                        {{ $related->genreRelation?->name ?? $related->genre }}
                    </div>
                    <h3>{{ $related->title }}</h3>
                    <p class="muted">by {{ $related->author?->name }}</p>
                    <div class="price-row">
                        <strong>${{ number_format($related->price, 2) }}</strong>
                        <span>Rating {{ number_format($related->rating, 1) }}</span>
                    </div>
                    <a class="button secondary" href="{{ route('book.detail', ['slug' => $related->slug]) }}">View Details</a>
                </article>
            @empty
                <div class="empty-state">No related books found yet.</div>
            @endforelse
        </div>
    </section>
</main>