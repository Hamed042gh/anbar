<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Services\Dashboard\DashboardStatsService;

class DashboardStats extends Widget
{
   protected string $view = 'filament.widgets.dashboard-stats';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = '60s';

    protected function getViewData(): array
    {
        return ['stats' => app(DashboardStatsService::class)->get()];
    }
}
