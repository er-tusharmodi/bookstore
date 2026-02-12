<?php

use App\Models\Author;
use Livewire\Component;

new class extends Component
{
        public string $search = '';
        public string $specialty = 'all';
        public string $city = 'all';
        public string $minBooks = '0';
        public string $followers = '0';
        public string $sort = 'name';

        public function clearFilters(): void
        {
                $this->search = '';
                $this->specialty = 'all';
                $this->city = 'all';
                $this->minBooks = '0';
                $this->followers = '0';
                $this->sort = 'name';
        }

        public function getAuthorsProperty()
        {
                $query = Author::query();

                if ($this->search !== '') {
                        $query->where(function ($builder) {
                                $builder
                                        ->where('name', 'like', "%{$this->search}%")
                                        ->orWhere('city', 'like', "%{$this->search}%")
                                        ->orWhere('specialty', 'like', "%{$this->search}%");
                        });
                }

                if ($this->specialty !== 'all') {
                        $query->where('specialty', $this->specialty);
                }

                if ($this->city !== 'all') {
                        $query->where('city', $this->city);
                }

                if ((int) $this->minBooks > 0) {
                        $query->where('published_books', '>=', (int) $this->minBooks);
                }

                if ((int) $this->followers > 0) {
                        $query->where('followers_count', '>=', (int) $this->followers);
                }

                match ($this->sort) {
                        'followers' => $query->orderByDesc('followers_count'),
                        'books' => $query->orderByDesc('published_books'),
                        default => $query->orderBy('name'),
                };

                return $query->get();
        }

        public function getSpecialtiesProperty()
        {
                return Author::query()
                        ->select('specialty')
                        ->whereNotNull('specialty')
                        ->distinct()
                        ->orderBy('specialty')
                        ->pluck('specialty');
        }

        public function getCitiesProperty()
        {
                return Author::query()
                        ->select('city')
                        ->whereNotNull('city')
                        ->distinct()
                        ->orderBy('city')
                        ->pluck('city');
        }
};
?>

<main class="page-shell">
    <section class="section reveal author-page-head">
        <h1>Author Directory</h1>
        <p class="section-subtitle">Find writers by specialty, city, output, and audience size.</p>
        <div class="pill-row">
            <span class="pill">Directory board</span>
            <span class="pill">Smart filters</span>
            <span class="pill ghost">Author spotlight</span>
        </div>
    </section>

    <div class="author-layout">
        <aside class="section reveal author-sidebar">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Refine Authors</h2>
                    <p class="section-subtitle">Adjust filters to narrow the directory fast.</p>
                </div>
            </div>

            <div class="control">
                <label for="authorSearch">Search</label>
                <input id="authorSearch" type="search" placeholder="Name, city, specialty" wire:model.live="search" />
            </div>
            <div class="control">
                <label for="specialtyFilter">Specialty</label>
                <select id="specialtyFilter" wire:model="specialty">
                    <option value="all">All specialties</option>
                    @foreach ($this->specialties as $specialtyOption)
                        <option value="{{ $specialtyOption }}">{{ $specialtyOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control">
                <label for="cityFilter">City</label>
                <select id="cityFilter" wire:model="city">
                    <option value="all">All cities</option>
                    @foreach ($this->cities as $cityOption)
                        <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control">
                <label for="minBooksFilter">Min published books</label>
                <select id="minBooksFilter" wire:model="minBooks">
                    <option value="0">Any</option>
                    <option value="3">3+</option>
                    <option value="5">5+</option>
                    <option value="7">7+</option>
                </select>
            </div>
            <div class="control">
                <label for="followersFilter">Min followers</label>
                <select id="followersFilter" wire:model="followers">
                    <option value="0">Any</option>
                    <option value="20">20k+</option>
                    <option value="30">30k+</option>
                    <option value="40">40k+</option>
                </select>
            </div>
            <div class="control">
                <label for="authorSortFilter">Sort</label>
                <select id="authorSortFilter" wire:model="sort">
                    <option value="name">Name A-Z</option>
                    <option value="followers">Most followers</option>
                    <option value="books">Most books</option>
                </select>
            </div>

            <button type="button" class="button secondary" wire:click="clearFilters">Clear filters</button>
        </aside>

        <section class="section reveal author-results">
            <div class="author-results-top">
                <div>
                    <h2 class="section-title">Directory Results</h2>
                    <p class="section-subtitle">{{ $this->authors->count() }} authors</p>
                </div>
            </div>

            <div class="grid cols-3">
                @forelse ($this->authors as $author)
                    <article class="card">
                        <div class="author-avatar">{{ strtoupper(substr($author->name, 0, 2)) }}</div>
                        <h3>{{ $author->name }}</h3>
                        <p class="muted">{{ $author->specialty }}</p>
                        <p class="muted">{{ $author->city }}</p>
                        <div class="pill-row">
                            <span class="pill ghost">{{ $author->published_books }} books</span>
                            <span class="pill">{{ $author->followers_count }} followers</span>
                        </div>
                        <a class="button secondary" href="{{ route('author.detail', ['slug' => $author->slug]) }}">View Profile</a>
                    </article>
                @empty
                    <div class="empty-state">No authors match these filters. Change specialty, city, or minimum limits.</div>
                @endforelse
            </div>
        </section>
    </div>
</main>