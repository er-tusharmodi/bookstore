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
use Filament\Widgets\FilementInfoWidget;
use App\Http\Middleware\EnsurePanelRole;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Enums\ThemeMode;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use App\Support\SiteSettingStore;
use Illuminate\Support\Facades\Storage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            
            // ✅ DARK MODE THEME - Professional dark interface
            ->darkMode(true)
            ->defaultThemeMode(ThemeMode::Dark)
            
            // ✅ CUSTOM COLOR PALETTE & BRANDING
            ->colors([
                'primary' => Color::Indigo,      // Modern indigo primary
                'secondary' => Color::Slate,      // Professional slate secondary
                'success' => Color::Emerald,      // Rich emerald for success
                'warning' => Color::Amber,        // Warm amber for warnings
                'danger' => Color::Rose,          // Deep rose for dangers
                'info' => Color::Blue,            // Clean blue for info
            ])
            
            // ✅ LAYOUT & SPACING ADJUSTMENTS & BRANDING
            ->sidebarWidth('20rem')  // Wider sidebar for better readability
            ->sidebarCollapsibleOnDesktop(true)  // Allow sidebar collapse
            ->brandName(function () {
                return (string) SiteSettingStore::get('site_name', 'BookNest');
            })  // Use site name only
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
            ->maxContentWidth('8xl')  // Maximum content width
            
            // ✅ NAVIGATION STYLING - Breadcrumbs for clarity
            ->breadcrumbs(true)  // Show breadcrumbs for navigation clarity
            ->collapsibleNavigationGroups(true)  // Allow navigation groups to collapse
            
            // Resource and page discovery
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            
            // Middleware stack
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
