<?php

use App\Models\Book;
use App\Models\Format;
use App\Models\Genre;
use Livewire\Component;

new class extends Component
{
        public string $search = '';
        public string $genre = 'all';
        public string $format = 'all';
        public string $sort = 'title';
        public string $rating = '0';
        public string $year = 'all';
        public float $maxPrice = 100;
        public float $maxPriceCap = 100;
        public bool $dealOnly = false;

        public function mount(): void
        {
                $this->maxPriceCap = (float) (Book::max('price') ?? 100);
                $this->maxPrice = $this->maxPriceCap;
        }

        public function clearFilters(): void
        {
                $this->search = '';
                $this->genre = 'all';
                $this->format = 'all';
                $this->sort = 'title';
                $this->rating = '0';
                $this->year = 'all';
                $this->maxPrice = $this->maxPriceCap;
                $this->dealOnly = false;
        }

        public function getBooksProperty()
        {
                $query = Book::query()->with(['author', 'genreRelation', 'formatRelation']);

                if ($this->search !== '') {
                        $query->where(function ($builder) {
                                $builder
                                        ->where('title', 'like', "%{$this->search}%")
                                        ->orWhereHas('author', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                                        ->orWhere('genre', 'like', "%{$this->search}%");
                        });
                }

                if ($this->genre !== 'all') {
                        $query->where('genre_id', $this->genre);
                }

                if ($this->format !== 'all') {
                        $query->where('format_id', $this->format);
                }

                if ($this->year !== 'all') {
                        $query->where('published_year', $this->year);
                }

                if ((float) $this->rating > 0) {
                        $query->where('rating', '>=', (float) $this->rating);
                }

                if ($this->dealOnly) {
                        $query->where('is_deal', true);
                }

                $query->where('price', '<=', $this->maxPrice);

                match ($this->sort) {
                        'newest' => $query->orderByDesc('published_year'),
                        'rating' => $query->orderByDesc('rating'),
                        'price-low' => $query->orderBy('price'),
                        'price-high' => $query->orderByDesc('price'),
                        default => $query->orderBy('title'),
                };

                return $query->get();
        }

        public function getGenresProperty()
        {
                return Genre::query()->where('is_active', true)->orderBy('name')->get();
        }

        public function getFormatsProperty()
        {
                return Format::query()->where('is_active', true)->orderBy('name')->get();
        }

        public function getYearsProperty()
        {
                return Book::query()->select('published_year')
                        ->whereNotNull('published_year')
                        ->distinct()
                        ->orderByDesc('published_year')
                        ->pluck('published_year');
        }
};
?>

<main class="page-shell">
    <section class="section reveal store-page-head">
        <h1>Store Catalog</h1>
        <p class="section-subtitle">Discover books with a faster catalog layout and sidebar filters.</p>
        <div class="pill-row">
            <span class="pill">Live search</span>
            <span class="pill">Quick filtering</span>
            <span class="pill ghost">Updated collection</span>
        </div>
    </section>

    <div class="store-layout">
        <aside class="section reveal store-sidebar">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Refine Results</h2>
                    <p class="section-subtitle">Set filters and instantly narrow your list.</p>
                </div>
            </div>

            <div class="control">
                <label for="bookSearch">Search</label>
                <input id="bookSearch" type="search" placeholder="Title, author, or genre" wire:model.live="search" />
            </div>
            <div class="control">
                <label for="genreFilter">Genre</label>
                <select id="genreFilter" wire:model="genre">
                    <option value="all">All genres</option>
                    @foreach ($this->genres as $genreOption)
                        <option value="{{ $genreOption->id }}">{{ $genreOption->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control">
                <label for="formatFilter">Format</label>
                <select id="formatFilter" wire:model="format">
                    <option value="all">All formats</option>
                    @foreach ($this->formats as $formatOption)
                        <option value="{{ $formatOption->id }}">{{ $formatOption->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control">
                <label for="sortFilter">Sort</label>
                <select id="sortFilter" wire:model="sort">
                    <option value="title">Title A-Z</option>
                    <option value="newest">Newest first</option>
                    <option value="rating">Top rating</option>
                    <option value="price-low">Price: low to high</option>
                    <option value="price-high">Price: high to low</option>
                </select>
            </div>
            <div class="control">
                <label for="ratingFilter">Minimum rating</label>
                <select id="ratingFilter" wire:model="rating">
                    <option value="0">Any rating</option>
                    <option value="4">4.0+</option>
                    <option value="4.5">4.5+</option>
                    <option value="4.8">4.8+</option>
                </select>
            </div>
            <div class="control">
                <label for="yearFilter">Published year</label>
                <select id="yearFilter" wire:model="year">
                    <option value="all">All years</option>
                    @foreach ($this->years as $yearOption)
                        <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control">
                <label for="maxPriceRange">Max price: <span>${{ number_format($maxPrice, 2) }}</span></label>
                <input id="maxPriceRange" type="range" min="0" max="{{ $maxPriceCap }}" step="0.5" wire:model="maxPrice" />
            </div>
            <div class="control check-row">
                <label for="dealOnly">Deals only</label>
                <input id="dealOnly" type="checkbox" wire:model="dealOnly" />
            </div>

            <button type="button" class="button secondary store-clear-btn" wire:click="clearFilters">Clear all filters</button>
        </aside>

        <section class="section reveal store-results">
            <div class="store-results-top">
                <div>
                    <h2 class="section-title">Books</h2>
                    <p class="section-subtitle">{{ $this->books->count() }} books</p>
                </div>
                <a class="button secondary" href="{{ route('authors') }}">Browse Authors</a>
            </div>

            <div class="grid cols-3 store-grid">
                @forelse ($this->books as $book)
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
                        <div class="item-actions" style="margin-top:0.6rem;">
                            <a class="button secondary" href="{{ route('book.detail', ['slug' => $book->slug]) }}">View Details</a>
                            <a class="button secondary" href="{{ route('author.detail', ['slug' => $book->author?->slug]) }}">About Author</a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">No books match your filters. Try clearing one filter and search again.</div>
                @endforelse
            </div>
        </section>
    </div>
</main>