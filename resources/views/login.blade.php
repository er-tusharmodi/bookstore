@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Login')
@section('page', 'login')

@section('content')
  <main class="page-shell login-main">
    <section class="hero reveal">
      <h1>Sign in to BookNest</h1>
      <p class="section-subtitle">Access your saved books, cart items, and reading shortlist from one place.</p>
    </section>

    <section class="login-layout reveal">
      <article class="login-card">
        <h1>Login</h1>
        <p class="muted" style="margin:0;">Use your email and password to continue.</p>

        <form class="login-form" action="{{ route('login.submit') }}" method="post">
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
          New to BookNest?
          <a href="{{ route('register') }}">Create an account</a>
        </p>
      </article>

      <article class="login-side">
        <h2>Why sign in?</h2>
        <p class="muted">Your account helps you keep your shopping and reading flow organized.</p>
        <ul class="list">
          <li>Save titles and compare later</li>
          <li>Track cart items in one place</li>
          <li>Get quicker checkout on next visit</li>
          <li>Follow favorite authors and releases</li>
        </ul>
        <div class="pill-row" style="margin-top:0.75rem;">
          <span class="pill">Secure login</span>
          <span class="pill ghost">Fast access</span>
        </div>
      </article>
    </section>
  </main>
@endsection
