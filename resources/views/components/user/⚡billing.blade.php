<?php

use App\Models\BillingAddress;
use Livewire\Component;

new class extends Component
{
        public ?BillingAddress $address = null;

        public function mount(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                $this->address = BillingAddress::where('user_id', $user->id)
                        ->orderByDesc('is_default')
                        ->latest('updated_at')
                        ->first();
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>Billing</h1>
        <p class="section-subtitle">Manage payment methods, addresses, and invoice history.</p>
    </section>

    <section class="account-layout reveal">
        <aside class="account-sidebar">
            <h2>Your Account</h2>
            <p class="account-subtitle">Manage your reading and orders.</p>
            <ul class="account-menu">
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                <li><a href="{{ route('user.cart') }}">Cart</a></li>
                <li><a class="active" href="{{ route('user.billing') }}">Billing</a></li>
                <li><a href="{{ route('user.profile') }}">Profile</a></li>
                <li><a href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <div class="account-grid-2">
                <article class="account-panel">
                    <h2>Billing Address</h2>
                    <form class="login-form" action="#" method="post">
                        <div class="control">
                            <label for="billName">Full Name</label>
                            <input id="billName" type="text" value="{{ $address?->name ?? '' }}" />
                        </div>
                        <div class="control">
                            <label for="billPhone">Phone Number</label>
                            <input id="billPhone" type="tel" value="{{ $address?->phone ?? '' }}" />
                        </div>
                        <div class="control">
                            <label for="billAddress">Street Address</label>
                            <input id="billAddress" type="text" value="{{ $address?->address ?? '' }}" />
                        </div>
                        <div class="account-grid-2" style="gap:.6rem;">
                            <div class="control">
                                <label for="billCity">City</label>
                                <input id="billCity" type="text" value="{{ $address?->city ?? '' }}" />
                            </div>
                            <div class="control">
                                <label for="billZip">ZIP Code</label>
                                <input id="billZip" type="text" value="{{ $address?->postal_code ?? '' }}" />
                            </div>
                        </div>
                        <button class="button" type="button">Save Address</button>
                    </form>
                </article>

                <article class="account-panel">
                    <h2>Payment Methods</h2>
                    <div class="item-list">
                        <div class="item-row">
                            <div>
                                <strong>Visa ending 2145</strong>
                                <p>Primary card · Expires 04/28</p>
                            </div>
                            <span class="status-pill success">Active</span>
                        </div>
                        <div class="item-row">
                            <div>
                                <strong>Mastercard ending 8891</strong>
                                <p>Backup card · Expires 11/27</p>
                            </div>
                            <span class="status-pill info">Saved</span>
                        </div>
                    </div>
                    <button class="button secondary" style="margin-top:0.75rem;" type="button">Add New Card</button>
                </article>
            </div>

            <article class="account-panel">
                <h2>Recent Invoices</h2>
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INV-4901</td>
                            <td>Feb 09, 2026</td>
                            <td>$38.89</td>
                            <td><span class="status-pill success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>INV-4868</td>
                            <td>Feb 03, 2026</td>
                            <td>$24.50</td>
                            <td><span class="status-pill success">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </article>
        </div>
    </section>
</main>