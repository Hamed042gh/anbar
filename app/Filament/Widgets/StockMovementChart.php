<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\StockMovement;
class StockMovementChart extends ChartWidget
{
    protected ?string $heading = 'ورود و خروج انبار';
    protected ?string $pollingInterval = '10s';
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 2;
protected function getData(): array
{
    $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

    $movements = StockMovement::query()
        ->selectRaw("DATE(created_at) as date, type, SUM(quantity) as total")
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date', 'type')
        ->get();

    $inData = $days->map(fn($d) =>
        (float) ($movements->where('type', 'purchase')->where('date', $d)->first()?->total ?? 0)
    );

    $outData = $days->map(fn($d) =>
        (float) ($movements->where('type', 'sale')->where('date', $d)->first()?->total ?? 0)
    );

    return [
        'datasets' => [
            [
                'label' => 'ورودی',
                'data' => $inData->values(),
                'borderColor' => '#10b981',
                'backgroundColor' => 'rgba(16, 185, 129, 0.08)',
                'borderWidth' => 2.5,
                'pointBackgroundColor' => '#10b981',
                'pointBorderColor' => '#fff',
                'pointBorderWidth' => 2,
                'pointRadius' => 3,
                'pointHoverRadius' => 6,
                'pointHoverBackgroundColor' => '#10b981',
                'fill' => true,
                'tension' => 0.4,
            ],
            [
                'label' => 'خروجی',
                'data' => $outData->values(),
                'borderColor' => '#f43f5e',
                'backgroundColor' => 'rgba(244, 63, 94, 0.08)',
                'borderWidth' => 2.5,
                'pointBackgroundColor' => '#f43f5e',
                'pointBorderColor' => '#fff',
                'pointBorderWidth' => 2,
                'pointRadius' => 3,
                'pointHoverRadius' => 6,
                'pointHoverBackgroundColor' => '#f43f5e',
                'fill' => true,
                'tension' => 0.4,
            ],
        ],
        'labels' => $days->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->values(),
    ];
}

protected function getOptions(): array
{
    return [
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'top',
                'align' => 'end',
                'labels' => [
                    'usePointStyle' => true,
                    'pointStyle' => 'circle',
                    'padding' => 16,
                    'font' => ['size' => 12],
                ],
            ],
            'tooltip' => [
                'mode' => 'index',
                'intersect' => false,
                'backgroundColor' => 'rgba(15, 23, 42, 0.9)',
                'titleColor' => '#94a3b8',
                'bodyColor' => '#f1f5f9',
                'borderColor' => 'rgba(148, 163, 184, 0.1)',
                'borderWidth' => 1,
                'padding' => 12,
                'cornerRadius' => 8,
            ],
        ],
        'scales' => [
            'x' => [
                'grid' => ['display' => false],
                'ticks' => [
                    'color' => '#94a3b8',
                    'font' => ['size' => 11],
                    'maxTicksLimit' => 10,
                ],
                'border' => ['display' => false],
            ],
            'y' => [
                'grid' => [
                    'color' => 'rgba(148, 163, 184, 0.08)',
                    'drawBorder' => false,
                ],
                'ticks' => [
                    'color' => '#94a3b8',
                    'font' => ['size' => 11],
                    'padding' => 8,
                ],
                'border' => ['display' => false, 'dash' => [4, 4]],
            ],
        ],
        'interaction' => [
            'mode' => 'index',
            'intersect' => false,
        ],
        'animation' => [
            'duration' => 800,
            'easing' => 'easeInOutQuart',
        ],
        'maintainAspectRatio' => false,
    ];
}
    protected function getType(): string
    {
        return 'line';
    }
}
