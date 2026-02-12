<?php

use App\Models\Wishlist;
use Livewire\Component;

new class extends Component
{
        public $items = [];
        public float $averagePrice = 0.0;
        public int $underTwenty = 0;
        public string $topGenre = 'N/A';

        public function mount(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                $wishlist = Wishlist::with('book.author')
                        ->where('user_id', $user->id)
                        ->get();

                $this->items = $wishlist->map(function ($entry) {
                        return [
                                'id' => $entry->id,
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
                                <p>{{ $item['author'] }} · ${{ number_format($item['price'], 2) }}</p>
                            </div>
                            <div class="item-actions">
                                <button class="button" type="button">Add to Cart</button>
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
                    <li><span>Average price</span><strong>${{ number_format($averagePrice, 2) }}</strong></li>
                    <li><span>Items under $20</span><strong>{{ $underTwenty }} books</strong></li>
                    <li><span>Top genre</span><strong>{{ $topGenre }}</strong></li>
                </ul>
            </article>
        </div>
    </section>
</main>