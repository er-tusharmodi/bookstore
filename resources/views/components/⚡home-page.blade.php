<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Genre;
use App\Models\HomepageSetting;
use App\Models\Wishlist;
use App\Support\SiteSettingStore;
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
        public string $currency = 'USD';
        public array $cartQuantities = [];
        public array $wishlistBookIds = [];

        public function loadCartQuantities(): void
        {
            $user = auth()->user();
            if (! $user) {
                return;
            }

            $cart = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if ($cart) {
                $items = CartItem::where('cart_id', $cart->id)->get();
                foreach ($items as $item) {
                    $this->cartQuantities[$item->book_id] = $item->quantity;
                }
            }
        }

        public function loadWishlist(): void
        {
            $user = auth()->user();
            if (! $user) {
                return;
            }
            $this->wishlistBookIds = Wishlist::where('user_id', $user->id)->pluck('book_id')->toArray();
        }

        public function addToCart(int $bookId): void
        {
            $user = auth()->user();
            if (! $user) {
                $this->redirectRoute('login');
                return;
            }

            $book = Book::find($bookId);
            if (! $book) {
                return;
            }

            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'status' => 'active'],
                ['checked_out_at' => null]
            );

            $item = CartItem::where('cart_id', $cart->id)
                ->where('book_id', $book->id)
                ->first();

            $quantity = $item ? $item->quantity + 1 : 1;
            $unitPrice = (float) $book->price;

            if ($item) {
                $item->update([
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $quantity * $unitPrice,
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'book_id' => $book->id,
                    'quantity' => 1,
                    'unit_price' => $unitPrice,
                    'line_total' => $unitPrice,
                ]);
            }

            $this->cartQuantities[$bookId] = $quantity;
            $this->dispatch('cart-updated', bookId: $bookId);
        }

    public function addToWishlist(int $bookId): void
    {
        $user = auth()->user();
        if (! $user) {
            $this->redirectRoute('login');
            return;
        }

        $book = Book::find($bookId);
        if (! $book) {
            return;
        }

        $wishlist = Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->first();
        
        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
            if (($key = array_search($bookId, $this->wishlistBookIds)) !== false) {
                unset($this->wishlistBookIds[$key]);
            }
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
            $this->wishlistBookIds[] = $bookId;
        }

        $this->dispatch('wishlist-updated', bookId: $bookId);
    }

    public function decrementFromCart(int $bookId): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();
        if (! $cart) {
            return;
        }

        $item = CartItem::where('cart_id', $cart->id)->where('book_id', $bookId)->first();
        if (! $item) {
            return;
        }

        $newQuantity = $item->quantity - 1;
        if ($newQuantity > 0) {
            $item->update([
                'quantity' => $newQuantity,
                'line_total' => $newQuantity * $item->unit_price,
            ]);
            $this->cartQuantities[$bookId] = $newQuantity;
        } else {
            $item->delete();
            unset($this->cartQuantities[$bookId]);
        }

        $this->dispatch('cart-updated', bookId: $bookId);
    }

        public function mount(): void
        {
                $this->settings = HomepageSetting::query()->latest()->first();
                $this->currency = (string) SiteSettingStore::get('currency', 'USD');

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
                        ? Author::withCount('books')->whereIn('id', $authorIds)->get()->values()
                        : Author::withCount('books')->orderByDesc('followers_count')->limit(6)->get();

                $this->statsBooks = $this->settings?->stats_books ?? Book::count();
                $this->statsAuthors = $this->settings?->stats_authors ?? Author::count();
                $this->statsGenres = $this->settings?->stats_genres ?? Genre::count();

                $this->loadCartQuantities();
                $this->loadWishlist();
        }
};
?>

<main class="page-shell">
    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">{{ $settings?->hero_title ?? 'Book Spotlight Deck' }}</h2>
                <p class="section-subtitle">{{ $settings?->hero_subtitle ?? 'Discover our curated selection of featured books.' }}</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Browse All</a>
        </div>

        <div class="grid cols-4">
            @forelse ($featuredBooks as $index => $book)
                <article class="card">
                    <div class="book-cover" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                        {{ $book->genreRelation?->name ?? $book->genre }}
                    </div>
                    <a href="{{ route('book.detail', ['slug' => $book->slug]) }}" style="text-decoration: none; color: inherit;">
                        <h3>{{ $book->title }}</h3>
                    </a>
                    <p class="muted">by {{ $book->author?->name }}</p>
                    <div class="price-row">
                        <strong>{{ $currency }} {{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    <div class="item-actions">
                        @auth
                            @if(($cartQuantities[$book->id] ?? 0) == 0)
                                <button type="button" class="button" wire:click="addToCart({{ $book->id }})" title="Add to Cart">Add to Cart</button>
                            @else
                                <div class="cart-counter">
                                    <button type="button" class="counter-btn minus" wire:click="decrementFromCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Decrease">-</button>
                                    <span class="counter-value" data-book-id="{{ $book->id }}">{{ $cartQuantities[$book->id] }}</span>
                                    <button type="button" class="counter-btn plus" wire:click="addToCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Increase">+</button>
                                </div>
                            @endif
                        @endauth
                        <button type="button" class="icon-btn wishlist-btn wishlist-badge" wire:click="addToWishlist({{ $book->id }})" data-book-id="{{ $book->id }}" title="Add to Wishlist" data-in-wishlist="{{ in_array($book->id, $wishlistBookIds) ? 'true' : 'false' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p class="muted">No featured books available.</p>
                </div>
            @endforelse
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
                    <a href="{{ route('book.detail', ['slug' => $book->slug]) }}" style="text-decoration: none; color: inherit;">
                        <h3>{{ $book->title }}</h3>
                    </a>
                    <p class="muted">by {{ $book->author?->name }}</p>
                    <div class="price-row">
                        <strong>{{ $currency }} {{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    <div class="item-actions">
                        @auth
                            @if(($cartQuantities[$book->id] ?? 0) == 0)
                                <button type="button" class="button" wire:click="addToCart({{ $book->id }})" title="Add to Cart">Add to Cart</button>
                            @else
                                <div class="cart-counter">
                                    <button type="button" class="counter-btn minus" wire:click="decrementFromCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Decrease">-</button>
                                    <span class="counter-value" data-book-id="{{ $book->id }}">{{ $cartQuantities[$book->id] }}</span>
                                    <button type="button" class="counter-btn plus" wire:click="addToCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Increase">+</button>
                                </div>
                            @endif
                        @endauth
                        <button type="button" class="icon-btn wishlist-btn" wire:click="addToWishlist({{ $book->id }})" title="Add to Wishlist">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
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
                    <a href="{{ route('book.detail', ['slug' => $book->slug]) }}" style="text-decoration: none; color: inherit;">
                        <h3>{{ $book->title }}</h3>
                    </a>
                    <p class="muted">by {{ $book->author?->name }}</p>
                    <div class="price-row">
                        <strong>{{ $currency }} {{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    <div class="item-actions">
                        @auth
                            @if(($cartQuantities[$book->id] ?? 0) == 0)
                                <button type="button" class="button" wire:click="addToCart({{ $book->id }})" title="Add to Cart">Add to Cart</button>
                            @else
                                <div class="cart-counter">
                                    <button type="button" class="counter-btn minus" wire:click="decrementFromCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Decrease">-</button>
                                    <span class="counter-value" data-book-id="{{ $book->id }}">{{ $cartQuantities[$book->id] }}</span>
                                    <button type="button" class="counter-btn plus" wire:click="addToCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Increase">+</button>
                                </div>
                            @endif
                        @endauth
                        <button type="button" class="icon-btn wishlist-btn wishlist-badge" wire:click="addToWishlist({{ $book->id }})" data-book-id="{{ $book->id }}" title="Add to Wishlist" data-in-wishlist="{{ in_array($book->id, $wishlistBookIds) ? 'true' : 'false' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
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
                <article class="card author-card">
                    <div class="author-card-header">
                        <div class="author-avatar-large">{{ strtoupper(substr($author->name, 0, 2)) }}</div>
                        <div class="author-card-info">
                            <h3>{{ $author->name }}</h3>
                            <p class="muted">{{ $author->specialty }}</p>
                        </div>
                    </div>
                    <div class="author-card-stats">
                        <div class="author-stat">
                            <strong>{{ number_format($author->books_count ?? 0) }}</strong>
                            <span>Books</span>
                        </div>
                        <div class="author-stat">
                            <strong>{{ number_format($author->followers_count ?? 0) }}</strong>
                            <span>Followers</span>
                        </div>
                    </div>
                    <a class="button" href="{{ route('author.detail', ['slug' => $author->slug]) }}">View Profile</a>
                </article>
            @endforeach
        </div>
    </section>
</main>