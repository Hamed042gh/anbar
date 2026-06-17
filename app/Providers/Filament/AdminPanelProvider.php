<?php

namespace App\Providers\Filament;


use App\Filament\Pages\EditProfile;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\LowStockTable;
use App\Filament\Widgets\MonthlySalesGoal;
use App\Filament\Widgets\RecentActivity;
use App\Filament\Widgets\StockMovementChart;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\Width;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('صفحه اصلی')
            ->authGuard('web')
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->profile(EditProfile::class)
            ->spa()
            ->globalSearchDebounce('500ms')
            

            ->colors([
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'warning' => Color::Orange,
                'info' => Color::Blue,
                'gray' => Color::Slate,
            ])
            ->databaseNotifications()
             ->maxContentWidth(Width::Full)
              ->unsavedChangesAlerts()
              ->databaseTransactions()

            ->darkMode(true)
              ->viteTheme('resources/css/filament/admin/theme.css')

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
      

            ->pages([
                Dashboard::class,
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')

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
                Authenticate::class,
            ])
            ->font(
                'Vazirmatn',
                url: asset('css/fonts.css'),
                provider: LocalFontProvider::class,
            );
    }
}