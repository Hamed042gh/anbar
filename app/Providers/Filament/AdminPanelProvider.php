<?php

namespace App\Providers\Filament;


use App\Enums\NavigationGroup;
use App\Filament\Pages\EditProfile;
use App\Filament\Pages\Settings;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\LowStockTable;
use App\Filament\Widgets\MonthlySalesGoal;
use App\Filament\Widgets\RecentActivity;
use App\Filament\Widgets\StockMovementChart;
use App\Models\Setting;
use Ariaieboy\FilamentJalali\FilamentJalaliPlugin;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentColor;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $color = Setting::get('primary_color', '#1E3A5F');

        FilamentColor::register([
            'primary' => Color::hex($color),
        ]);
        return $panel
            ->default()
            ->brandName(fn () => Setting::get('company_name', 'صفحه اصلی'))
            ->authGuard('web')
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->profile(EditProfile::class)
            ->spa()
            ->topNavigation()
            ->globalSearchDebounce('500ms')
            
            ->colors([
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
                Settings::class,
            ])
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn () => view('filament.loading-overlay'),
            )
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
            // ->plugins([
            //     FilamentJalaliPlugin::make(),
            // ])
            ->font(
                'Vazirmatn',
                url: asset('css/fonts.css'),
                provider: LocalFontProvider::class,
            );
    }
}