<?php

use App\Models\Cart;
use Livewire\Component;

new class extends Component
{
        public $items = [];
        public float $subtotal = 0.0;
        public float $shipping = 0.0;
        public float $tax = 0.0;
        public float $total = 0.0;

        public function mount(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                $cart = Cart::with('items.book')
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->latest('updated_at')
                        ->first();

                if (! $cart) {
                        return;
                }

                $this->items = $cart->items->map(function ($item) {
                        $price = $item->unit_price ?: ($item->book?->price ?? 0);
                        $lineTotal = $price * $item->quantity;

                        return [
                                'title' => $item->book?->title ?? 'Unknown',
                                'quantity' => $item->quantity,
                                'price' => $price,
                                'total' => $lineTotal,
                        ];
                })->all();

                $this->subtotal = collect($this->items)->sum('total');
                $this->shipping = $this->subtotal > 0 ? 4.99 : 0;
                $this->tax = $this->subtotal * 0.045;
                $this->total = $this->subtotal + $this->shipping + $this->tax;
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>Cart</h1>
        <p class="section-subtitle">Review cart items, quantities, and checkout total.</p>
    </section>

    <section class="account-layout reveal">
        <aside class="account-sidebar">
            <h2>Your Account</h2>
            <p class="account-subtitle">Manage your reading and orders.</p>
            <ul class="account-menu">
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                <li><a class="active" href="{{ route('user.cart') }}">Cart</a></li>
                <li><a href="{{ route('user.billing') }}">Billing</a></li>
                <li><a href="{{ route('user.profile') }}">Profile</a></li>
                <li><a href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <div class="account-grid-2">
                <article class="account-panel">
                    <h2>Cart Items</h2>
                    <table class="account-table">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item['title'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td>${{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Your cart is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </article>

                <article class="account-panel">
                    <h2>Order Summary</h2>
                    <ul class="summary-list">
                        <li><span>Subtotal</span><strong>${{ number_format($subtotal, 2) }}</strong></li>
                        <li><span>Shipping</span><strong>${{ number_format($shipping, 2) }}</strong></li>
                        <li><span>Tax</span><strong>${{ number_format($tax, 2) }}</strong></li>
                        <li class="total"><span>Total</span><strong>${{ number_format($total, 2) }}</strong></li>
                    </ul>
                    <button class="button" style="margin-top:0.9rem;width:100%;" type="button">Proceed to Checkout</button>
                    <button class="button secondary" style="margin-top:0.5rem;width:100%;" type="button">Continue Shopping</button>
                </article>
            </div>

            <article class="account-panel">
                <h2>Delivery Note</h2>
                <p class="account-subtitle">Orders usually arrive within 2-4 business days after payment confirmation.</p>
            </article>
        </div>
    </section>
</main>