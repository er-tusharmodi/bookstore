<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
      $siteName = \App\Support\SiteSettingStore::get('site_name', 'BookNest');
    @endphp
    <title>@yield('title', $siteName)</title>
    <meta name="description" content="@yield('meta_description', 'BookNest is a modern bookstore website with curated books, featured authors, and clean browsing filters.')" />
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
  <body data-page="@yield('page', 'home')" data-auth="{{ auth()->check() ? '1' : '0' }}">
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
          <a data-page-link="home" href="{{ route('home') }}">Home</a>
          <a data-page-link="store" href="{{ route('store') }}">Store</a>
          <a data-page-link="authors" href="{{ route('authors') }}">Authors</a>
        </nav>
        <div class="top-utilities">
          @auth
            <a class="login-btn" href="{{ route('user.dashboard') }}">Dashboard</a>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="login-btn" type="submit">Logout</button>
            </form>
          @else
            <a class="login-btn" href="{{ route('login') }}">Login</a>
          @endauth
        </div>
      </div>
    </header>

    @yield('content')

    @php
      $footerPages = \App\Models\Page::query()
        ->where('is_published', true)
        ->orderBy('title')
        ->get();
    @endphp
    @php
      $supportLinks = \App\Support\SiteSettingStore::get('support_links', []);
      $supportLinks = is_array($supportLinks) && count($supportLinks) > 0 ? $supportLinks : [
        [
          'title' => 'Help Center',
          'text' => 'Get quick help and FAQs',
        ],
        [
          'title' => 'Legacy Catalog',
          'text' => 'Open the classic catalog route',
        ],
        [
          'title' => 'Contact Authors',
          'text' => 'Browse and connect with authors',
        ],
      ];
    @endphp
    <footer class="site-footer">
      <section class="footer-newsletter">
        <div class="page-shell footer-newsletter-inner">
          <div>
            <h3>Stay in the reading loop</h3>
            <p>Get weekly picks, fresh arrivals, and editor favorites.</p>
          </div>
          <form class="footer-form" action="#" method="get">
            <input type="email" name="email" placeholder="Enter your email" aria-label="Email address" />
            <button type="button">Subscribe</button>
          </form>
        </div>
      </section>

      <div class="page-shell footer-main">
        <section class="footer-brand">
          <a class="footer-logo" href="{{ route('home') }}">
            <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" style="height: {{ $logoHeightValue }}; width: auto;" />
          </a>
          <p>Discover trusted books, compare authors, and find your next read quickly.</p>
        </section>

        <section class="footer-col">
          <h4>Browse</h4>
          <ul class="footer-links">
            @foreach ($footerPages as $footerPage)
              <li><a href="{{ route('page.show', ['slug' => $footerPage->slug]) }}">{{ $footerPage->title }}</a></li>
            @endforeach
          </ul>
        </section>

        <section class="footer-col">
          <h4>Collections</h4>
          <ul class="footer-links">
            <li><a href="{{ route('store') }}">Top Rated</a></li>
            <li><a href="{{ route('store') }}">New Arrivals</a></li>
            <li><a href="{{ route('store') }}">Under $20</a></li>
          </ul>
        </section>

        <section class="footer-col footer-support-col">
          <h4>Support</h4>
          <ul class="footer-links footer-support-links">
            @foreach ($supportLinks as $supportLink)
              <li>
                <div class="support-link-card">
                  <span class="support-link-icon" aria-hidden="true">{{ mb_substr($supportLink['title'] ?? '?', 0, 1) }}</span>
                  <span>
                    <strong>{{ $supportLink['title'] ?? 'Support' }}</strong>
                    <small>{{ $supportLink['text'] ?? '' }}</small>
                  </span>
                </div>
              </li>
            @endforeach
          </ul>
        </section>
      </div>

      <div class="footer-meta">
        <div class="page-shell footer-meta-inner">
          <p>© 2026 {{ $siteName }}. Built for readers.</p>
          <div class="footer-badges">
            <span>Secure Checkout</span>
            <span>Fast Discovery</span>
            <span>Curated Catalog</span>
          </div>
        </div>
      </div>
    </footer>

    @livewireScripts
    <script src="{{ asset('app.js') }}" defer></script>
  </body>
</html>
