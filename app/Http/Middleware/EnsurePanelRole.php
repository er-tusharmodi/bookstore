<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class EnsurePanelRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        $panel = Filament::getCurrentPanel();
        $panelId = $panel?->getId();

        $requiredRole = match ($panelId) {
            'admin' => 'super_admin',
            'store' => 'store',
            'author' => 'author',
            default => null,
        };

        if ($requiredRole && $user->hasRole($requiredRole)) {
            return $next($request);
        }

        abort(403);
    }
}
