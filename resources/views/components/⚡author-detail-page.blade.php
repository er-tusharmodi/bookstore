<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Support\SiteSettingStore;
use Livewire\Component;

new class extends Component
{
        public string $slug = '';
        public ?Author $author = null;
        public string $currency = 'USD';
        public array $wishlistBookIds = [];
        public array $cartQuantities = [];
        public bool $isFollowing = false;

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
        $this->author = Author::query()
            ->with(['books.genreRelation', 'books.formatRelation'])
            ->where('slug', $slug)
            ->firstOrFail();
        $this->loadFollowStatus();
        }

        public function loadFollowStatus(): void
        {
            $user = auth()->user();
            if (! $user || ! $this->author) {
                return;
            }
            $this->isFollowing = $user->followingAuthors()->where('author_id', $this->author->id)->exists();
        }

        public function toggleFollow(): void
        {
            $user = auth()->user();
            if (! $user) {
                $this->redirectRoute('login');
                return;
            }

            if ($this->isFollowing) {
                $user->followingAuthors()->detach($this->author->id);
                $this->author->decrement('followers_count');
                $this->isFollowing = false;
            } else {
                $user->followingAuthors()->attach($this->author->id);
                $this->author->increment('followers_count');
                $this->isFollowing = true;
            }

            $this->author->refresh();
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
            if (! $cart) {
                return;
            }
            $items = CartItem::where('cart_id', $cart->id)->get();
            foreach ($items as $item) {
                $this->cartQuantities[$item->book_id] = $item->quantity;
            }
        }
};
?>

<main class="page-shell">
    <section class="section reveal author-detail-hero">
        <div class="author-hero-content">
            <p class="section-subtitle" style="margin: 0 0 2em 0; padding-left: 2em;">
                <a href="{{ route('authors') }}">Authors</a> / <span>{{ $author->name }}</span>
            </p>
            <div class="author-hero-main" style="padding-left: 2em;">
                <div class="author-avatar-hero">{{ strtoupper(substr($author->name, 0, 2)) }}</div>
                <div class="author-hero-info">
                    <h1 style="margin: 0 0 0.5rem 0;">{{ $author->name }}</h1>
                    <p class="muted" style="margin: 0 0 1rem 0; max-width: 60ch;">{{ $author->bio }}</p>
                    
                    @auth
                        <button 
                            wire:click="toggleFollow" 
                            class="button {{ $isFollowing ? 'secondary' : '' }}"
                            style="margin-bottom: 1rem; padding: 0.5rem 1.2rem; font-size: 0.85rem; display: inline-flex; gap: 0.4rem; align-items: center;">
                            @if($isFollowing)
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                Following
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                                Follow
                            @endif
                        </button>
                    @endauth
                    
                    <div class="author-hero-meta">
                        <div class="author-hero-stat">
                            <strong>{{ number_format($author->books->count()) }}</strong>
                            <span>Books</span>
                        </div>
                        <div class="author-hero-stat">
                            <strong>{{ number_format($author->followers_count) }}</strong>
                            <span>Followers</span>
                        </div>
                        <div class="author-hero-stat">
                            <strong>{{ $author->specialty }}</strong>
                            <span>Specialty</span>
                        </div>
                    </div>
                </div>
            </div>
            @if($author->quote)
                <blockquote class="author-hero-quote">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.3;">
                        <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                    </svg>
                    <p>{{ $author->quote }}</p>
                </blockquote>
            @endif
        </div>
    </section>

    <section class="section reveal">
        <div class="section-head">
            <div>
                <h2 class="section-title">Books by {{ $author->name }}</h2>
                <p class="section-subtitle">{{ $author->books->count() }} titles available in the catalog.</p>
            </div>
            <a class="button secondary" href="{{ route('store') }}">Browse Store</a>
        </div>
        <div class="grid cols-4">
            @foreach ($author->books as $book)
                <article class="card">
                    <div class="book-cover" style="background: {{ $book->cover_tone ?? '#232f3e' }};">
                        {{ $book->genreRelation?->name ?? $book->genre }}
                    </div>
                    <a href="{{ route('book.detail', ['slug' => $book->slug]) }}" style="text-decoration: none; color: inherit;">
                        <h3>{{ $book->title }}</h3>
                    </a>
                    <p class="muted">by {{ $author->name }}</p>
                    <div class="price-row">
                        <strong>{{ $currency }} {{ number_format($book->price, 2) }}</strong>
                        <span>Rating {{ number_format($book->rating, 1) }}</span>
                    </div>
                    @auth
                    <div class="item-actions">
                        @if(($cartQuantities[$book->id] ?? 0) == 0)
                            <button type="button" class="button" wire:click="addToCart({{ $book->id }})" title="Add to Cart">Add to Cart</button>
                        @else
                            <div class="cart-counter">
                                <button type="button" class="counter-btn minus" wire:click="decrementFromCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Decrease">-</button>
                                <span class="counter-value" data-book-id="{{ $book->id }}">{{ $cartQuantities[$book->id] }}</span>
                                <button type="button" class="counter-btn plus" wire:click="addToCart({{ $book->id }})" data-book-id="{{ $book->id }}" title="Increase">+</button>
                            </div>
                        @endif
                        <button type="button" class="icon-btn wishlist-btn wishlist-badge" wire:click="addToWishlist({{ $book->id }})" data-book-id="{{ $book->id }}" title="Add to Wishlist" data-in-wishlist="{{ in_array($book->id, $wishlistBookIds) ? 'true' : 'false' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                    @else
                    <div class="item-actions">
                        <button type="button" class="button" onclick="window.location.href='{{ route('login') }}'">Add to Cart</button>
                        <button type="button" class="icon-btn wishlist-btn wishlist-badge" onclick="window.location.href='{{ route('login') }}'" title="Add to Wishlist">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                    @endauth
                </article>
            @endforeach
        </div>
    </section>
</main>

<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('cart-updated', (event) => {
        const bookId = event.bookId;
        console.log('Cart updated for book:', bookId);
    });
    
    Livewire.on('wishlist-updated', (event) => {
        const bookId = event.bookId;
        const wishlistBtn = document.querySelector(`.wishlist-badge[data-book-id="${bookId}"]`);
        if (wishlistBtn) {
            const currentState = wishlistBtn.getAttribute('data-in-wishlist') === 'true';
            wishlistBtn.setAttribute('data-in-wishlist', !currentState);
        }
    });
});
</script>