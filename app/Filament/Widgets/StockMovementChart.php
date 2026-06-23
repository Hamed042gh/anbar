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
    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $days = collect(range(13, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $movements = StockMovement::query()
            ->selectRaw("DATE(created_at) as date, type, SUM(quantity) as total")
            ->where('created_at', '>=', now()->subDays(14))
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
                    'borderColor' => '#6ee7b7',
                    'backgroundColor' => 'rgba(110, 231, 183, 0.06)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => '#6ee7b7',
                    'pointBorderColor' => 'transparent',
                    'pointBorderWidth' => 0,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 5,
                    'pointHoverBackgroundColor' => '#6ee7b7',
                    'pointHoverBorderColor' => '#fff',
                    'pointHoverBorderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.45,
                ],
                [
                    'label' => 'خروجی',
                    'data' => $outData->values(),
                    'borderColor' => '#fb7185',
                    'backgroundColor' => 'rgba(251, 113, 133, 0.06)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => '#fb7185',
                    'pointBorderColor' => 'transparent',
                    'pointBorderWidth' => 0,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 5,
                    'pointHoverBackgroundColor' => '#fb7185',
                    'pointHoverBorderColor' => '#fff',
                    'pointHoverBorderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.45,
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
                        'padding' => 20,
                        'font' => ['size' => 11, 'weight' => '500'],
                        'color' => '#94a3b8',
                        'boxWidth' => 7,
                        'boxHeight' => 7,
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.95)',
                    'titleColor' => '#64748b',
                    'titleFont' => ['size' => 11],
                    'bodyColor' => '#f1f5f9',
                    'bodyFont' => ['size' => 12, 'weight' => '600'],
                    'borderColor' => 'rgba(148, 163, 184, 0.12)',
                    'borderWidth' => 1,
                    'padding' => 10,
                    'cornerRadius' => 6,
                    'caretSize' => 5,
                    'displayColors' => true,
                    'boxWidth' => 7,
                    'boxHeight' => 7,
                    'usePointStyle' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'color' => '#475569',
                        'font' => ['size' => 10],
                        'maxTicksLimit' => 7,
                        'maxRotation' => 0,
                    ],
                    'border' => ['display' => false],
                ],
                'y' => [
                    'grid' => [
                        'color' => 'rgba(148, 163, 184, 0.06)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => '#475569',
                        'font' => ['size' => 10],
                        'padding' => 10,
                        'maxTicksLimit' => 5,
                    ],
                    'border' => ['display' => false],
                    'beginAtZero' => true,
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'animation' => [
                'duration' => 600,
                'easing' => 'easeOutCubic',
            ],
            'maintainAspectRatio' => false,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}