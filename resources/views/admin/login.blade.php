@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Admin Login')
@section('page', 'login')

@section('content')
  <main class="page-shell login-main">
    <section class="hero reveal">
      <h1>Admin Panel Login</h1>
      <p class="section-subtitle">Sign in to manage stores, authors, and books.</p>
    </section>

    <section class="login-layout reveal">
      <article class="login-card">
        <h1>Panel Login</h1>
        <p class="muted" style="margin:0;">Use your admin, store, or author credentials.</p>

        <form class="login-form" action="{{ route('panel.login.submit') }}" method="post">
          @csrf
          <div class="control">
            <label for="loginEmail">Email Address</label>
            <input id="loginEmail" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required />
            @error('email')
              <small class="muted">{{ $message }}</small>
            @enderror
          </div>

          <div class="control">
            <label for="loginPassword">Password</label>
            <input id="loginPassword" name="password" type="password" placeholder="Enter your password" required />
            @error('password')
              <small class="muted">{{ $message }}</small>
            @enderror
          </div>

          <div class="login-row">
            <label class="muted" style="display:inline-flex;align-items:center;gap:.4rem;">
              <input type="checkbox" name="remember" />
              Remember me
            </label>
            <a href="#">Forgot password?</a>
          </div>

          <button class="button login-submit" type="submit">Login Securely</button>
        </form>

        <p class="login-note muted">
          Need a customer account?
          <a href="{{ route('register') }}">Register here</a>
        </p>
      </article>

      <article class="login-side">
        <h2>Panel Access</h2>
        <p class="muted">Admins, store managers, and authors log in here.</p>
        <ul class="list">
          <li>Manage books and inventory</li>
          <li>Track orders and fulfillment</li>
          <li>Update author profiles</li>
          <li>Review catalog performance</li>
        </ul>
        <div class="pill-row" style="margin-top:0.75rem;">
          <span class="pill">Secure login</span>
          <span class="pill ghost">Role-based access</span>
        </div>
      </article>
    </section>
  </main>
@endsection
