<?php

use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

new class extends Component
{
        public string $name = '';
        public string $email = '';
        public string $phone = '';
        public bool $emailNotifications = true;
        public bool $smsNotifications = true;
        public bool $authorRecommendations = false;

        public string $currentPassword = '';
        public string $newPassword = '';
        public string $confirmPassword = '';

        public function mount(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                $profile = UserProfile::firstOrNew(['user_id' => $user->id]);

                $this->name = $user->name;
                $this->email = $user->email;
                $this->phone = $profile->phone ?? '';
                $this->emailNotifications = (bool) $profile->email_notifications;
                $this->smsNotifications = (bool) $profile->sms_notifications;
                $this->authorRecommendations = (bool) $profile->author_recommendations;
        }

        public function saveProfile(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                $user->update([
                        'name' => $this->name,
                        'email' => $this->email,
                ]);

                UserProfile::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                                'phone' => $this->phone,
                                'email_notifications' => $this->emailNotifications,
                                'sms_notifications' => $this->smsNotifications,
                                'author_recommendations' => $this->authorRecommendations,
                        ]
                );
        }

        public function updatePassword(): void
        {
                $user = auth()->user();
                if (! $user) {
                        return;
                }

                if (! Hash::check($this->currentPassword, $user->password)) {
                        $this->addError('currentPassword', 'Current password is incorrect.');
                        return;
                }

                if ($this->newPassword !== $this->confirmPassword) {
                        $this->addError('confirmPassword', 'Passwords do not match.');
                        return;
                }

                $user->update([
                        'password' => $this->newPassword,
                ]);

                $this->currentPassword = '';
                $this->newPassword = '';
                $this->confirmPassword = '';
        }
};
?>

<main class="page-shell account-main">
    <section class="hero reveal">
        <h1>Profile</h1>
        <p class="section-subtitle">Update your personal info, password, and account preferences.</p>
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
                <li><a class="active" href="{{ route('user.profile') }}">Profile</a></li>
                <li><a href="{{ route('user.orders') }}">Order List</a></li>
            </ul>
        </aside>

        <div class="account-content">
            <div class="account-grid-2">
                <article class="account-panel">
                    <h2>Personal Information</h2>
                    <form class="login-form" wire:submit.prevent="saveProfile">
                        <div class="control">
                            <label for="profileName">Full Name</label>
                            <input id="profileName" type="text" wire:model="name" />
                        </div>
                        <div class="control">
                            <label for="profileEmail">Email</label>
                            <input id="profileEmail" type="email" wire:model="email" />
                        </div>
                        <div class="control">
                            <label for="profilePhone">Phone</label>
                            <input id="profilePhone" type="tel" wire:model="phone" />
                        </div>
                        <button class="button" type="submit">Save Profile</button>
                    </form>
                </article>

                <article class="account-panel">
                    <h2>Security</h2>
                    <form class="login-form" wire:submit.prevent="updatePassword">
                        <div class="control">
                            <label for="oldPassword">Current Password</label>
                            <input id="oldPassword" type="password" wire:model="currentPassword" />
                            @error('currentPassword')<small class="muted">{{ $message }}</small>@enderror
                        </div>
                        <div class="control">
                            <label for="newPassword">New Password</label>
                            <input id="newPassword" type="password" wire:model="newPassword" />
                        </div>
                        <div class="control">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input id="confirmPassword" type="password" wire:model="confirmPassword" />
                            @error('confirmPassword')<small class="muted">{{ $message }}</small>@enderror
                        </div>
                        <button class="button secondary" type="submit">Update Password</button>
                    </form>
                </article>
            </div>

            <article class="account-panel">
                <h2>Preferences</h2>
                <div class="item-list">
                    <label class="item-row">
                        <span>
                            <strong>Email Notifications</strong>
                            <p>Get updates for offers and new arrivals.</p>
                        </span>
                        <input type="checkbox" wire:model="emailNotifications" />
                    </label>
                    <label class="item-row">
                        <span>
                            <strong>Order SMS Alerts</strong>
                            <p>Receive shipping and delivery alerts.</p>
                        </span>
                        <input type="checkbox" wire:model="smsNotifications" />
                    </label>
                    <label class="item-row">
                        <span>
                            <strong>Author Recommendations</strong>
                            <p>Suggestions based on your wishlist and orders.</p>
                        </span>
                        <input type="checkbox" wire:model="authorRecommendations" />
                    </label>
                </div>
            </article>
        </div>
    </section>
</main>