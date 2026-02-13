<?php

use App\Models\Wishlist;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Support\SiteSettingStore;
use Livewire\Component;

new class extends Component
{
        public $items = [];
        public float $averagePrice = 0.0;
        public int $underTwenty = 0;
        public string $topGenre = 'N/A';
        public string $currency = 'USD';

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

            $this->dispatch('cart-updated');
        }

        public function mount(): void
        {
                $user = auth()->user();
                $this->currency = (string) SiteSettingStore::get('currency', 'USD');
                if (! $user) {
                        return;
                }

                $wishlist = Wishlist::with('book.author')
                        ->where('user_id', $user->id)
                        ->get();

                $this->items = $wishlist->map(function ($entry) {
                        return [
                                'id' => $entry->id,
                        'book_id' => $entry->book?->id,
                                'title' => $entry->book?->title ?? 'Unknown',
                                'author' => $entry->book?->author?->name ?? 'Unknown',
                                'price' => $entry->book?->price ?? 0,
                        ];
                })->all();

                if ($wishlist->isNotEmpty()) {
                        $this->averagePrice = $wishlist->avg('book.price') ?? 0;
                        $this->underTwenty = $wishlist->filter(fn ($entry) => ($entry->book?->price ?? 0) < 20)->count();
                        $this->topGenre = $wishlist
                                ->groupBy(fn ($entry) => $entry->book?->genre ?? 'N/A')
                                ->sortByDesc(fn ($group) => $group->count())
                                ->keys()
                                ->first() ?? 'N/A';
                }
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>Wishlist</h1>
        <p class="section-subtitle">Your saved titles in one place. Move any book to cart when ready.</p>
    </section>

    <section class="account-layout reveal">
        <aside class="account-sidebar">
            <h2>Your Account</h2>
            <p class="account-subtitle">Manage your reading and orders.</p>
            <ul class="account-menu">
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a class="active" href="{{ route('user.wishlist') }}">Wishlist</a></li>
                <li><a href="{{ route('user.cart') }}">Cart</a></li>
                <li><a href="{{ route('user.billing') }}">Billing</a></li>
                <li><a href="{{ route('user.profile') }}">Profile</a></li>
                <li><a href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <article class="account-panel">
                <h2>Saved Books</h2>
                <p class="account-subtitle">{{ count($items) }} books currently in your wishlist.</p>
                <div class="item-list">
                    @forelse ($items as $item)
                        <div class="item-row">
                            <div>
                                <strong>{{ $item['title'] }}</strong>
                                <p>{{ $item['author'] }} · {{ $currency }} {{ number_format($item['price'], 2) }}</p>
                            </div>
                            <div class="item-actions">
                                <button class="icon-btn cart-btn" type="button" wire:click="addToCart({{ $item['book_id'] }})" title="Add to Cart">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                </button>
                                <button class="button secondary" type="button">Remove</button>
                            </div>
                        </div>
                    @empty
                        <div class="item-row">
                            <div>
                                <strong>No saved books yet</strong>
                                <p>Browse the catalog and start saving your favorites.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </article>

            <article class="account-panel">
                <h2>Wishlist Insights</h2>
                <ul class="summary-list">
                    <li><span>Average price</span><strong>{{ $currency }} {{ number_format($averagePrice, 2) }}</strong></li>
                    <li><span>Items under $20</span><strong>{{ $underTwenty }} books</strong></li>
                    <li><span>Top genre</span><strong>{{ $topGenre }}</strong></li>
                </ul>
            </article>
        </div>
    </section>
</main>