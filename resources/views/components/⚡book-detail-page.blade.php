<?php

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Support\SiteSettingStore;
use Livewire\Component;

new class extends Component
{
    public string $slug = '';
    public ?Book $book = null;
    public $relatedBooks;
    public string $currency = 'USD';
    public array $wishlistBookIds = [];
    public array $cartQuantities = [];

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

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->currency = (string) SiteSettingStore::get('currency', 'USD');
        $this->loadWishlist();
        $this->loadCartQuantities();
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

    public function loadWishlist(): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }
        $this->wishlistBookIds = Wishlist::where('user_id', $user->id)->pluck('book_id')->toArray();
    }

    public function loadCartQuantities(): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }
        $cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();
        if ($cart) {
            $items = CartItem::where('cart_id', $cart->id)->get();
            foreach ($items as $item) {
                $this->cartQuantities[$item->book_id] = $item->quantity;
            }
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
                <strong>{{ $currency }} {{ number_format($book->price, 2) }}</strong>
                <span>Rating {{ number_format($book->rating, 1) }}</span>
            </div>

            <div class="product-actions">
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
                @guest
                    <button type="button" class="button" onclick="window.location.href='{{ route('login') }}'" title="Login to add to cart">Add to Cart</button>
                @endguest
                <button type="button" class="icon-btn wishlist-btn wishlist-badge" wire:click="addToWishlist({{ $book->id }})" data-book-id="{{ $book->id }}" title="Add to Wishlist" data-in-wishlist="{{ in_array($book->id, $wishlistBookIds) ? 'true' : 'false' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </button>
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
                    <a href="{{ route('book.detail', ['slug' => $related->slug]) }}" style="text-decoration: none; color: inherit;">
                        <h3>{{ $related->title }}</h3>
                    </a>
                    <p class="muted">by {{ $related->author?->name }}</p>
                    <div class="price-row">
                        <strong>{{ $currency }} {{ number_format($related->price, 2) }}</strong>
                        <span>Rating {{ number_format($related->rating, 1) }}</span>
                    </div>
                    <div class="item-actions">
                        @auth
                            @if(($cartQuantities[$related->id] ?? 0) == 0)
                                <button type="button" class="button" wire:click="addToCart({{ $related->id }})" title="Add to Cart">Add to Cart</button>
                            @else
                                <div class="cart-counter">
                                    <button type="button" class="counter-btn minus" wire:click="decrementFromCart({{ $related->id }})" data-book-id="{{ $related->id }}" title="Decrease">-</button>
                                    <span class="counter-value" data-book-id="{{ $related->id }}">{{ $cartQuantities[$related->id] }}</span>
                                    <button type="button" class="counter-btn plus" wire:click="addToCart({{ $related->id }})" data-book-id="{{ $related->id }}" title="Increase">+</button>
                                </div>
                            @endif
                        @endauth
                        <button type="button" class="icon-btn wishlist-btn wishlist-badge" wire:click="addToWishlist({{ $related->id }})" data-book-id="{{ $related->id }}" title="Add to Wishlist" data-in-wishlist="{{ in_array($related->id, $wishlistBookIds) ? 'true' : 'false' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                </article>
            @empty
                <div class="empty-state">No related books found yet.</div>
            @endforelse
        </div>
    </section>
</main>