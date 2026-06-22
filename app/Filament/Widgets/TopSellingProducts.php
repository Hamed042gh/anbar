<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TopSellingProducts extends TableWidget
{
    protected static ?string $heading = 'پرفروش‌ترین کالاهای این هفته';
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
                    ->join('invoice_items', 'invoice_items.variant_id', '=', 'product_variants.id')
                    ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->where('invoices.issued_at', '>=', now()->subDays(7))
                    ->where('invoices.status', 'confirmed')
                    ->groupBy('products.id', 'products.name')
                    ->select(
                        'products.id',
                        'products.name as product_name',
                        DB::raw('SUM(invoice_items.quantity) as total_quantity'),
                        DB::raw('SUM(invoice_items.total_price) as total_revenue')
                    )
                    ->orderByDesc('total_quantity')
                    ->limit(5)
            )
            ->paginated(false)
            ->striped()
            ->columns([
                TextColumn::make('product_name')
                    ->label('کالا')
                    ->weight('bold')
                    ->icon('heroicon-m-cube')
                    ->iconColor('primary'),

                TextColumn::make('total_quantity')
                    ->label('تعداد فروش')
                    ->badge()
                    ->color('success')
                    ->suffix(' عدد')
                    ->alignCenter(),

                TextColumn::make('total_revenue')
                    ->label('درآمد')
                    ->formatStateUsing(fn($state) => number_format($state) . ' تومان')
                    ->color('warning')
                    ->weight('bold')
                    ->alignEnd(),
            ]);
    }
}
