<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
      $siteName = \App\Support\SiteSettingStore::get('site_name', 'BookNest');
    @endphp
    <title>@yield('title', $siteName.' | Account')</title>
    @php
      $faviconPath = \App\Support\SiteSettingStore::get('favicon_path', 'favicon.ico');
      $faviconUrl = str_starts_with((string) $faviconPath, 'http')
        ? $faviconPath
        : (str_starts_with((string) $faviconPath, 'storage/')
          ? asset($faviconPath)
          : (\Illuminate\Support\Facades\Storage::disk('public')->exists((string) $faviconPath)
            ? \Illuminate\Support\Facades\Storage::disk('public')->url((string) $faviconPath)
            : asset($faviconPath)));
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" />
    <link rel="stylesheet" href="{{ asset('theme.css') }}" />
    @livewireStyles
  </head>
  <body data-page="user-account" data-auth="{{ auth()->check() ? '1' : '0' }}">
    @php
      $logoPath = \App\Support\SiteSettingStore::get('logo_path', 'logo.png');
      $logoAlt = \App\Support\SiteSettingStore::get('logo_alt', 'BookNest');
      $logoHeight = \App\Support\SiteSettingStore::get('logo_height', '40px');
      $logoHeightValue = is_numeric($logoHeight) ? $logoHeight.'px' : $logoHeight;
      $logoUrl = str_starts_with($logoPath, 'http')
        ? $logoPath
        : (str_starts_with($logoPath, 'storage/')
          ? asset($logoPath)
          : (\Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($logoPath)
            : asset($logoPath)));
    @endphp
    <header class="site-header">
      <div class="page-shell header-inner">
        <a class="brand" href="{{ route('home') }}">
          <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" style="height: {{ $logoHeightValue }}; width: auto;" />
        </a>
        <nav class="nav-links">
          <a href="{{ route('home') }}">Home</a>
          <a href="{{ route('store') }}">Store</a>
          <a href="{{ route('authors') }}">Authors</a>
        </nav>
        <div class="top-utilities">
          <a class="login-btn" href="{{ route('user.dashboard') }}">Dashboard</a>
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="login-btn" type="submit">Logout</button>
          </form>
        </div>
      </div>
    </header>

    @yield('content')

    <footer class="site-footer">
      <div class="page-shell footer-meta-inner">
        <p>© 2026 {{ $siteName }}. User account center.</p>
        <div class="footer-badges">
          <span>Secure Account</span>
          <span>Order Tracking</span>
          <span>Fast Checkout</span>
        </div>
      </div>
    </footer>

    <div id="toast-container" class="toast-container" aria-live="polite" aria-atomic="true"></div>

    @livewireScripts
    <script>
      document.addEventListener('livewire:initialized', () => {
        const container = document.getElementById('toast-container');
        if (!container) {
          return;
        }

        const showToast = (message) => {
          const toast = document.createElement('div');
          toast.className = 'toast';
          toast.textContent = message;
          container.appendChild(toast);

          requestAnimationFrame(() => {
            toast.classList.add('show');
          });

          setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 200);
          }, 2500);
        };

        Livewire.on('cart-updated', (data) => {
          showToast('Cart updated');
          // Reload cart quantities from server
          if (data && data.bookId !== undefined) {
            // Counter is already updated by Livewire re-render, no need to manually increment
          }
        });
        Livewire.on('wishlist-updated', (data) => {
          if (data && data.bookId !== undefined) {
            const badge = document.querySelector(`.wishlist-badge[data-book-id="${data.bookId}"]`);
            if (badge) {
              const isCurrentlyFalse = badge.getAttribute('data-in-wishlist') === 'false';
              badge.setAttribute('data-in-wishlist', !isCurrentlyFalse);
              showToast(isCurrentlyFalse ? 'Added to wishlist' : 'Removed from wishlist');
            }
          }
        });

        // Handle cart counter minus button (kept for backward compatibility, but Livewire handles it now)
        document.addEventListener('click', (e) => {
          if (e.target.closest('.counter-btn.minus')) {
            // Counter decrement is now handled by Livewire decrementFromCart() method
            // This listener is kept but doesn't need to do anything
          }
        });
      });
    </script>
  </body>
</html>
