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

    @livewireScripts
  </body>
</html>
