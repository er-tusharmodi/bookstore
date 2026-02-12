@extends('layouts.site')

@section('title', \App\Support\SiteSettingStore::get('site_name', 'BookNest').' | Register')
@section('page', 'register')

@section('content')
  <main class="page-shell login-main">
    <section class="hero reveal">
      <h1>Create your BookNest account</h1>
      <p class="section-subtitle">Register once to save books, track cart items, and get faster checkout.</p>
    </section>

    <section class="login-layout reveal">
      <article class="login-card">
        <h1>Register</h1>
        <p class="muted" style="margin:0;">Fill in your details to create a new account.</p>

        <form class="login-form" action="{{ route('register.submit') }}" method="post">
          @csrf
          <div class="control">
            <label for="registerName">Full Name</label>
            <input id="registerName" name="name" type="text" placeholder="Your full name" value="{{ old('name') }}" required />
            @error('name')
              <small class="muted">{{ $message }}</small>
            @enderror
          </div>

          <div class="control">
            <label for="registerEmail">Email Address</label>
            <input id="registerEmail" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required />
            @error('email')
              <small class="muted">{{ $message }}</small>
            @enderror
          </div>

          <div class="control">
            <label for="registerPhone">Mobile Number</label>
            <input id="registerPhone" name="phone" type="tel" placeholder="+1 000 000 0000" />
          </div>

          <div class="control">
            <label for="registerPassword">Password</label>
            <input id="registerPassword" name="password" type="password" placeholder="Create password" required />
            @error('password')
              <small class="muted">{{ $message }}</small>
            @enderror
          </div>

          <div class="control">
            <label for="registerConfirmPassword">Confirm Password</label>
            <input id="registerConfirmPassword" name="password_confirmation" type="password" placeholder="Re-enter password" required />
          </div>

          <label class="muted" style="display:inline-flex;align-items:flex-start;gap:.45rem;">
            <input type="checkbox" name="terms" required />
            <span>I agree to the terms, privacy policy, and account guidelines.</span>
          </label>

          <button class="button login-submit" type="submit">Create Account</button>
        </form>

        <p class="login-note muted">
          Already have an account?
          <a href="{{ route('login') }}">Login here</a>
        </p>
      </article>

      <article class="login-side">
        <h2>What you get with registration</h2>
        <p class="muted">A single account keeps your shopping and reading preferences synced.</p>
        <ul class="list">
          <li>Save books and compare quickly</li>
          <li>Manage your cart from any page</li>
          <li>Follow favorite authors</li>
          <li>Access faster checkout flow</li>
        </ul>
        <div class="pill-row" style="margin-top:0.75rem;">
          <span class="pill">Quick signup</span>
          <span class="pill ghost">Secure account</span>
        </div>
      </article>
    </section>
  </main>
@endsection
