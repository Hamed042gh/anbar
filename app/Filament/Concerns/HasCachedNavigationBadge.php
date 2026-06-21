<?php

namespace App\Filament\Concerns;

trait HasCachedNavigationBadge
{
    public static function getNavigationBadge(): ?string
    {
        return (string) cache()->remember(
            static::class . '_nav_badge',
            now()->addMinutes(1),
            fn () => static::getModel()::count()
        );
    }
}