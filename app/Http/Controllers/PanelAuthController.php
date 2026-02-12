<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectFor(Auth::user());
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectFor(Auth::user())->getTargetUrl());
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->onlyInput('email');
    }

    private function redirectFor(?User $user): RedirectResponse
    {
        if (! $user) {
            return redirect()->route('panel.login');
        }

        if ($user->hasRole('super_admin')) {
            return redirect('/admin');
        }

        if ($user->hasRole('store')) {
            return redirect('/store');
        }

        if ($user->hasRole('author')) {
            return redirect('/author');
        }

        return redirect()->route('user.dashboard');
    }
}
