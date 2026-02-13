<?php

use App\Models\Order;
use App\Support\SiteSettingStore;
use Livewire\Component;

new class extends Component
{
        public $orders = [];
        public string $currency = 'USD';

        public function mount(): void
        {
                $user = auth()->user();
                $this->currency = (string) SiteSettingStore::get('currency', 'USD');
                if (! $user) {
                        return;
                }

                $this->orders = Order::with('items')
                        ->where('user_id', $user->id)
                        ->latest('placed_at')
                        ->get()
                        ->map(function (Order $order) {
                                $statusClass = match ($order->status) {
                                        'delivered', 'completed' => 'success',
                                        'shipped' => 'info',
                                        'processing' => 'warning',
                                        'cancelled' => 'danger',
                                        default => 'info',
                                };

                                return [
                                        'number' => $order->order_number,
                                        'date' => optional($order->placed_at)->format('M d, Y') ?? 'Pending',
                                        'items' => $order->items->sum('quantity'),
                                        'amount' => $order->total,
                                        'status' => ucfirst($order->status),
                                        'statusClass' => $statusClass,
                                ];
                        })
                        ->all();
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>Order List</h1>
        <p class="section-subtitle">Track all your purchases, deliveries, and return windows.</p>
    </section>

    <section class="account-layout reveal">
        <aside class="account-sidebar">
            <h2>Your Account</h2>
            <p class="account-subtitle">Manage your reading and orders.</p>
            <ul class="account-menu">
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                <li><a href="{{ route('user.cart') }}">Cart</a></li>
                <li><a href="{{ route('user.billing') }}">Billing</a></li>
                <li><a href="{{ route('user.profile') }}">Profile</a></li>
                <li><a class="active" href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <article class="account-panel">
                <h2>Recent Orders</h2>
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order['number'] }}</td>
                                <td>{{ $order['date'] }}</td>
                                <td>{{ $order['items'] }}</td>
                                <td>{{ $currency }} {{ number_format($order['amount'], 2) }}</td>
                                <td><span class="status-pill {{ $order['statusClass'] }}">{{ $order['status'] }}</span></td>
                                <td><button type="button" class="button secondary">View Details</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No orders found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </article>

            <article class="account-panel">
                <h2>Support Help</h2>
                <p class="account-subtitle">Need changes in an order? Use billing page for invoice requests and profile page for contact updates.</p>
                <div class="item-actions" style="margin-top:.8rem;">
                    <a class="button secondary" href="{{ route('user.billing') }}">Billing Help</a>
                    <a class="button secondary" href="{{ route('user.profile') }}">Update Contact</a>
                </div>
            </article>
        </div>
    </section>
</main>