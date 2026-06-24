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
            ->renderHook(
    PanelsRenderHook::BODY_END,
    fn () => new \Illuminate\Support\HtmlString('
    <script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("counter", (target, decimals = 0) => ({
            value: 0,
            init() {
                const duration = 900;
                const start = performance.now();
                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    this.value = target * eased;
                    if (progress < 1) requestAnimationFrame(step);
                    else this.value = target;
                };
                requestAnimationFrame(step);
            },
            toFa(str) {
                const fa = ["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
                return str.replace(/[0-9]/g, d => fa[d]);
            },
            formatted() {
                const str = this.value.toLocaleString("en-US", {
                    maximumFractionDigits: decimals,
                    minimumFractionDigits: decimals,
                });
                return this.toFa(str);
            },
        }));
    });
    </script>
    '),
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
