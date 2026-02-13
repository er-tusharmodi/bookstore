<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\Wishlist;
use App\Support\SiteSettingStore;
use Livewire\Component;

new class extends Component
{
        public int $savedBooks = 0;
        public int $cartItems = 0;
        public int $ordersThisMonth = 0;
        public float $walletCredits = 0.0;
        public float $totalSpent = 0.0;
        public float $avgOrderValue = 0.0;
        public int $totalOrders = 0;
        public array $recentActivity = [];
        public array $recentOrders = [];
        public string $currency = 'USD';

        public function mount(): void
        {
                $user = auth()->user();
                $this->currency = (string) SiteSettingStore::get('currency', 'USD');
                if (! $user) {
                        return;
                }

                $this->savedBooks = Wishlist::where('user_id', $user->id)->count();
                $activeCart = Cart::withCount('items')
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->latest('updated_at')
                        ->first();

                $this->cartItems = $activeCart?->items_count ?? 0;
                $this->ordersThisMonth = Order::where('user_id', $user->id)
                        ->whereMonth('placed_at', now()->month)
                        ->whereYear('placed_at', now()->year)
                        ->count();

                $this->totalOrders = Order::where('user_id', $user->id)
                        ->where('status', '!=', 'cancelled')
                        ->count();

                $this->totalSpent = Order::where('user_id', $user->id)
                        ->where('status', '!=', 'cancelled')
                        ->sum('total');

                $this->avgOrderValue = $this->totalOrders > 0 ? $this->totalSpent / $this->totalOrders : 0;

                $this->recentActivity = Order::where('user_id', $user->id)
                        ->latest('placed_at')
                        ->take(3)
                        ->get()
                        ->map(function (Order $order) {
                                $statusClass = match ($order->status) {
                                        'completed', 'delivered' => 'success',
                                        'shipped' => 'info',
                                        'processing' => 'warning',
                                        'cancelled' => 'danger',
                                        default => 'info',
                                };

                                return [
                                        'title' => "Placed order {$order->order_number}",
                                        'date' => optional($order->placed_at)->format('M d, Y') ?? 'Pending',
                                        'status' => ucfirst($order->status),
                                        'statusClass' => $statusClass,
                                ];
                        })
                        ->all();

                $this->recentOrders = Order::where('user_id', $user->id)
                        ->latest('placed_at')
                        ->take(5)
                        ->get()
                        ->map(function (Order $order) {
                                return [
                                        'order_number' => $order->order_number,
                                        'total' => $this->currency . ' ' . number_format($order->total, 2),
                                        'status' => ucfirst($order->status),
                                        'date' => optional($order->placed_at)->format('M d, Y'),
                                        'items_count' => $order->items()->count(),
                                ];
                        })
                        ->all();
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>User Dashboard</h1>
        <p class="section-subtitle">Track saved books, cart progress, recent orders, and account shortcuts.</p>
    </section>

    <section class="account-layout reveal">
        <aside class="account-sidebar">
            <h2>Your Account</h2>
            <p class="account-subtitle">Manage your reading and orders.</p>
            <ul class="account-menu">
                <li><a class="active" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                <li><a href="{{ route('user.cart') }}">Cart</a></li>
                <li><a href="{{ route('user.billing') }}">Billing</a></li>
                <li><a href="{{ route('user.profile') }}">Profile</a></li>
                <li><a href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <article class="account-panel">
                <h2>Welcome back, {{ auth()->user()?->name ?? 'Reader' }}</h2>
                <p class="account-subtitle">Here is a quick snapshot of your account.</p>
                <div class="account-kpi-grid">
                    <div class="account-kpi"><strong>{{ $savedBooks }}</strong><span>Saved Books</span></div>
                    <div class="account-kpi"><strong>{{ $cartItems }}</strong><span>Cart Items</span></div>
                    <div class="account-kpi"><strong>{{ $totalOrders }}</strong><span>Total Orders</span></div>
                    <div class="account-kpi"><strong>{{ $currency }} {{ number_format($totalSpent, 2) }}</strong><span>Total Spent</span></div>
                    <div class="account-kpi"><strong>{{ $currency }} {{ number_format($avgOrderValue, 2) }}</strong><span>Avg Order</span></div>
                    <div class="account-kpi"><strong>{{ $ordersThisMonth }}</strong><span>This Month</span></div>
                </div>
            </article>

            <div class="account-grid-2">
                <article class="account-panel">
                    <h2>Recent Orders (Last 5)</h2>
                    <table class="account-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td><strong>{{ $order['order_number'] }}</strong></td>
                                    <td>{{ $order['items_count'] }} item(s)</td>
                                    <td>{{ $order['total'] }}</td>
                                    <td>{{ $order['date'] }}</td>
                                    <td><span class="status-pill {{ match($order['status']) {
                                        'Delivered' => 'success',
                                        'Shipped' => 'info',
                                        'Processing' => 'warning',
                                        'Cancelled' => 'danger',
                                        default => 'info',
                                    } }}">{{ $order['status'] }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No orders yet. <a href="{{ route('store') }}">Start shopping!</a></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </article>

                <article class="account-panel">
                    <h2>Recent Activity</h2>
                    <table class="account-table">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentActivity as $activity)
                                <tr>
                                    <td>{{ $activity['title'] }}</td>
                                    <td>{{ $activity['date'] }}</td>
                                    <td><span class="status-pill {{ $activity['statusClass'] }}">{{ $activity['status'] }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No recent activity yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </article>
            </div>

            <article class="account-panel">
                <h2>Quick Actions</h2>
                <p class="account-subtitle">Jump directly to key account sections.</p>
                <div class="item-list">
                    <div class="item-row">
                        <div>
                            <strong>Continue Shopping</strong>
                            <p>Discover new books and authors in our store.</p>
                        </div>
                        <a class="button secondary" href="{{ route('store') }}">Browse</a>
                    </div>
                    <div class="item-row">
                        <div>
                            <strong>View Wishlist</strong>
                            <p>Check your {{ $savedBooks }} saved books and move to cart.</p>
                        </div>
                        <a class="button secondary" href="{{ route('user.wishlist') }}">Open</a>
                    </div>
                    <div class="item-row">
                        <div>
                            <strong>Track Orders</strong>
                            <p>Follow shipment and delivery status of your purchases.</p>
                        </div>
                        <a class="button secondary" href="{{ route('user.orders') }}">Open</a>
                    </div>
                    <div class="item-row">
                        <div>
                            <strong>Review Cart</strong>
                            <p>You have {{ $cartItems }} item(s) waiting in your cart.</p>
                        </div>
                        <a class="button secondary" href="{{ route('user.cart') }}">Open</a>
                    </div>
                    <div class="item-row">
                        <div>
                            <strong>Update Profile</strong>
                            <p>Keep account details and delivery addresses current.</p>
                        </div>
                        <a class="button secondary" href="{{ route('user.profile') }}">Open</a>
                    </div>
                    <div class="item-row">
                        <div>
                            <strong>Manage Billing</strong>
                            <p>View invoices and manage payment methods.</p>
                        </div>
                        <a class="button secondary" href="{{ route('user.billing') }}">Open</a>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>