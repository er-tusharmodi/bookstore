<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\HomepageSetting;
use Livewire\Component;

new class extends Component
{
        public $spotlightBook;
        public $featuredBooks = [];
        public $moreBooks = [];
        public $featuredAuthors = [];
        public int $statsBooks = 0;
        public int $statsAuthors = 0;
        public int $statsGenres = 0;
        public ?HomepageSetting $settings = null;

        public function mount(): void
        {
                $this->settings = HomepageSetting::query()->latest()->first();

                $spotlightId = $this->settings?->spotlight_book_id;
                $this->spotlightBook = $spotlightId
                        ? Book::with('author')->find($spotlightId)
                        : Book::with('author')->latest()->first();

                $featuredIds = $this->settings?->featured_book_ids ?? [];
                $this->featuredBooks = $featuredIds
                        ? Book::with('author')->whereIn('id', $featuredIds)->get()->values()
                        : Book::with('author')->where('is_featured', true)->limit(4)->get();

                $moreIds = $this->settings?->more_book_ids ?? [];
                $this->moreBooks = $moreIds
                        ? Book::with('author')->whereIn('id', $moreIds)->get()->values()
                        : Book::with('author')->latest()->limit(8)->get();

                $authorIds = $this->settings?->featured_author_ids ?? [];
                $this->featuredAuthors = $authorIds
                        ? Author::whereIn('id', $authorIds)->get()->values()
                        : Author::orderByDesc('followers_count')->limit(6)->get();

                $this->statsBooks = $this->settings?->stats_books ?? Book::count();
                $this->statsAuthors = $this->settings?->stats_authors ?? Author::count();
                $this->statsGenres = $this->settings?->stats_genres ?? Genre::count();
        }
};
?>

<main class="page-shell">
    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">{{ $settings?->hero_title ?? 'Book Spotlight Deck' }}</h2>
                <p class="section-subtitle">{{ $settings?->hero_subtitle ?? 'Use thumbnails to switch featured books instantly.' }}</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Open Store</a>
        </div>

        <div class="highlight-deck">
            <article class="highlight-main">
                @if ($spotlightBook)
                    <div class="card">
                        <div class="pill-row">
                            <span class="pill">Spotlight</span>
                            <span class="pill ghost">{{ $spotlightBook->formatRelation?->name ?? $spotlightBook->format }}</span>
                        </div>
                        <h3>{{ $spotlightBook->title }}</h3>
                        <p class="muted">{{ $spotlightBook->blurb }}</p>
                        <div class="price-row">
                            <strong>${{ number_format($spotlightBook->price, 2) }}</strong>
                            <span>Rating {{ number_format($spotlightBook->rating, 1) }}</span>
                        </div>
                        <a class="button" href="{{ route('book.detail', ['slug' => $spotlightBook->slug]) }}">View Book</a>
                    </div>
                @else
                    <p class="muted">No spotlight book yet.</p>
                @endif
            </article>
            <div class="highlight-controls">
                <div class="highlight-thumbs">
                    @foreach ($featuredBooks as $book)
                        <a class="chip" href="{{ route('book.detail', ['slug' => $book->slug]) }}">{{ $book->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="hero-grid">
            <div class="stat">
                <strong>{{ $statsBooks }}</strong>
                <span>Books in catalog</span>
            </div>
            <div class="stat">
                <strong>{{ $statsAuthors }}</strong>
                <span>Featured authors</span>
            </div>
            <div class="stat">
                <strong>{{ $statsGenres }}</strong>
                <span>Genres available</span>
            </div>
        </div>
    </section>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">Featured Books</h2>
                <p class="section-subtitle">Top-rated picks from the store.</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Open Store</a>
        </div>
        <div class="grid cols-4">
            @foreach ($featuredBooks as $book)
                <article class="card">
                    <div class="book-cover" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                        {{ $book->genreRelation?->name ?? $book->genre }}
                    </div>
                    <h3>{{ $book->title }}</h3>
                    <p class="muted">by {{ $book->author?->name }}</p>
                    <div class="price-row">
                        <strong>${{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    <a class="button secondary" href="{{ route('book.detail', ['slug' => $book->slug]) }}">View Details</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">More Books</h2>
                <p class="section-subtitle">Larger selection from latest and popular titles.</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">View Full Catalog</a>
        </div>
        <div class="grid cols-4">
            @foreach ($moreBooks as $book)
                <article class="card">
                    <div class="book-cover" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                        {{ $book->genreRelation?->name ?? $book->genre }}
                    </div>
                    <h3>{{ $book->title }}</h3>
                    <p class="muted">by {{ $book->author?->name }}</p>
                    <div class="price-row">
                        <strong>${{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    <a class="button secondary" href="{{ route('book.detail', ['slug' => $book->slug]) }}">View Details</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">Popular Authors</h2>
                <p class="section-subtitle">Writers readers are following most.</p>
            </div>
            <a class="button secondary" href="{{ route('authors') }}">See All Authors</a>
        </div>
        <div class="grid cols-3">
            @foreach ($featuredAuthors as $author)
                <article class="card">
                    <div class="author-avatar">{{ strtoupper(substr($author->name, 0, 2)) }}</div>
                    <h3>{{ $author->name }}</h3>
                    <p class="muted">{{ $author->specialty }}</p>
                    <a class="button secondary" href="{{ route('author.detail', ['slug' => $author->slug]) }}">View Profile</a>
                </article>
            @endforeach
        </div>
    </section>
</main>