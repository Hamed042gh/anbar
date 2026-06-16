<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

enum NavigationGroup implements HasLabel, HasIcon
{
    case Products;
    case Warehouse;
    case Purchase;
    case Sales;
    case Settings;

    public function getLabel(): string
    {
        return match ($this) {
            self::Products  => 'محصولات',
            self::Warehouse => 'انبار',
            self::Purchase  => 'خرید',
            self::Sales     => 'فروش',
            self::Settings  => 'تنظیمات',
        };
    }

    public function getIcon(): string | BackedEnum | Htmlable | null
    {
        return match ($this) {
            self::Products  => Heroicon::OutlinedRectangleStack,
            self::Warehouse => Heroicon::OutlinedBuildingStorefront,
            self::Purchase  => Heroicon::OutlinedTruck,
            self::Sales     => Heroicon::OutlinedDocumentCurrencyDollar,
            self::Settings  => Heroicon::OutlinedCog6Tooth,
        };
    }
}