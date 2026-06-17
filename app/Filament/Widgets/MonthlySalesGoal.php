<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Invoice;

class MonthlySalesGoal extends Widget
{
    protected string $view = 'filament.widgets.monthly-sales-goal';
    protected ?string $pollingInterval = '30s';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 4;
    protected int $goal = 500_000_000;

    public function getProgress(): array
    {
        $achieved = Invoice::whereMonth('issued_at', now()->month)
            ->whereYear('issued_at', now()->year)
            ->sum('payable_amount');

        $percentage = $this->goal > 0 ? min(100, round(($achieved / $this->goal) * 100, 1)) : 0;

        $color = match (true) {
            $percentage >= 100 => 'success',
            $percentage >= 60 => 'warning',
            default => 'danger',
        };

        return [
            'achieved' => $achieved,
            'goal' => $this->goal,
            'percentage' => $percentage,
            'color' => $color,
        ];
    }
}