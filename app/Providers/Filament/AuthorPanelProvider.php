<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsurePanelAuth;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Http\Middleware\EnsurePanelRole;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Support\SiteSettingStore;
use Illuminate\Support\Facades\Storage;

class AuthorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('author')
            ->path('author')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName(function () {
                return (string) SiteSettingStore::get('site_name', 'BookNest');
            })
            ->brandLogo(function () {
                $logoPath = SiteSettingStore::get('logo_light_path', SiteSettingStore::get('logo_path', 'logo.png'));
                $logoUrl = str_starts_with((string) $logoPath, 'http')
                    ? $logoPath
                    : (str_starts_with((string) $logoPath, 'storage/')
                        ? asset($logoPath)
                        : (Storage::disk('public')->exists((string) $logoPath)
                            ? Storage::disk('public')->url((string) $logoPath)
                            : asset($logoPath)));

                return $logoUrl;
            })
            ->darkModeBrandLogo(function () {
                $logoPath = SiteSettingStore::get('logo_path', 'logo.png');
                $logoUrl = str_starts_with((string) $logoPath, 'http')
                    ? $logoPath
                    : (str_starts_with((string) $logoPath, 'storage/')
                        ? asset($logoPath)
                        : (Storage::disk('public')->exists((string) $logoPath)
                            ? Storage::disk('public')->url((string) $logoPath)
                            : asset($logoPath)));

                return $logoUrl;
            })
            ->brandLogoHeight(fn (): string => (string) SiteSettingStore::get('logo_height', '40px'))
            ->favicon(function () {
                $faviconPath = SiteSettingStore::get('favicon_path', 'favicon.ico');

                return str_starts_with((string) $faviconPath, 'http')
                    ? $faviconPath
                    : (str_starts_with((string) $faviconPath, 'storage/')
                        ? asset($faviconPath)
                        : (Storage::disk('public')->exists((string) $faviconPath)
                            ? Storage::disk('public')->url((string) $faviconPath)
                            : asset($faviconPath)));
            })
            ->maxContentWidth('8xl')
            ->discoverResources(in: app_path('Filament/Author/Resources'), for: 'App\Filament\Author\Resources')
            ->discoverPages(in: app_path('Filament/Author/Pages'), for: 'App\Filament\Author\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Author/Widgets'), for: 'App\Filament\Author\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                EnsurePanelAuth::class,
                EnsurePanelRole::class,
            ]);
    }
}
