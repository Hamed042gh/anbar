<x-filament-widgets::widget>
    <x-filament::section>
        <div dir="rtl" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- ارزش کل موجودی --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-white/5 ring-1 ring-gray-950/5 dark:ring-white/10 p-5 flex flex-col gap-3 transition hover:ring-success-500/30">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full bg-success-500/10 blur-xl"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">ارزش کل موجودی</span>
                    <div class="rounded-lg bg-success-500/10 p-1.5">
                        <x-heroicon-o-building-storefront class="w-5 h-5 text-success-500" />
                    </div>
                </div>
                @php
                    $growth = $stats->salesTrendPercent ?? 0;
                    $ringPct = max(0, min(abs($growth), 100));
                @endphp
                <div class="relative flex items-center gap-4">
                    <svg width="56" height="56" viewBox="0 0 56 56" class="shrink-0">
                        <circle cx="28" cy="28" r="23" fill="none" stroke-width="6" class="stroke-gray-100 dark:stroke-white/10" />
                        <circle cx="28" cy="28" r="23" fill="none" stroke-width="6" stroke-linecap="round"
                            pathLength="100" stroke-dasharray="{{ $ringPct }} 100" transform="rotate(-90 28 28)"
                            class="{{ $growth >= 0 ? 'stroke-success-500' : 'stroke-danger-500' }} transition-all duration-700" />
                    </svg>
                    <div>
                        <p class="text-2xl font-bold tracking-tight">{{ fa_number($stats->inventoryValue) }}</p>
                        <p class="text-xs font-medium {{ $growth >= 0 ? 'text-success-600' : 'text-danger-600' }} mt-0.5">
                            {{ $growth >= 0 ? '+' : '' }}{{ fa_number($growth, 1) }}٪ نسبت به دیروز
                        </p>
                    </div>
                </div>
            </div>

            {{-- کالاهای رو به اتمام --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-white/5 ring-1 ring-gray-950/5 dark:ring-white/10 p-5 flex flex-col gap-2 transition hover:ring-danger-500/30">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full bg-danger-500/10 blur-xl"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">کالاهای رو به اتمام</span>
                    <div class="rounded-lg bg-danger-500/10 p-1.5">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-danger-500" />
                    </div>
                </div>
                <svg width="100%" height="44" viewBox="0 0 120 60" class="relative">
                    <path d="M10,55 A50,50 0 0,1 110,55" fill="none" stroke-width="8" pathLength="100" class="stroke-gray-100 dark:stroke-white/10" />
                    <path d="M10,55 A50,50 0 0,1 110,55" fill="none" stroke-width="8" stroke-linecap="round"
                        pathLength="100" stroke-dasharray="{{ $stats->lowStockRatio }} 100"
                        class="{{ $stats->lowStockCount > 5 ? 'stroke-danger-500' : ($stats->lowStockCount > 0 ? 'stroke-warning-500' : 'stroke-success-500') }} transition-all duration-700" />
                </svg>
                <div class="relative flex items-baseline justify-between">
                    <p class="text-2xl font-bold tracking-tight">
                        {{ fa_number($stats->lowStockCount) }}
                        <span class="text-sm font-medium text-gray-400">قلم</span>
                    </p>
                    <span class="text-xs font-medium {{ $stats->lowStockCount > 0 ? 'text-danger-600' : 'text-success-600' }}">
                        {{ $stats->lowStockCount > 0 ? 'نیاز فوری به سفارش' : 'موجودی کافیست' }}
                    </span>
                </div>
            </div>

            {{-- سفارش‌های در جریان --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-white/5 ring-1 ring-gray-950/5 dark:ring-white/10 p-5 flex flex-col gap-3 transition hover:ring-info-500/30">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full bg-info-500/10 blur-xl"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">سفارش‌های در جریان</span>
                    <div class="rounded-lg bg-info-500/10 p-1.5">
                        <x-heroicon-o-truck class="w-5 h-5 text-info-500" />
                    </div>
                </div>
                @php
                    $b = $stats->pendingByStatus;
                    $total = max(array_sum($b), 1);
                @endphp
                <p class="relative text-2xl font-bold tracking-tight">
                    {{ fa_number($stats->pendingOrdersCount) }}
                    <span class="text-sm font-medium text-gray-400">سفارش</span>
                </p>
                <div class="relative flex h-2 rounded-full overflow-hidden bg-gray-100 dark:bg-white/10">
                    <div class="bg-info-500 transition-all duration-700" style="width: {{ ($b['sent'] ?? 0) / $total * 100 }}%"></div>
                    <div class="bg-info-300 transition-all duration-700" style="width: {{ ($b['draft'] ?? 0) / $total * 100 }}%"></div>
                    <div class="bg-info-200 transition-all duration-700" style="width: {{ ($b['partial'] ?? 0) / $total * 100 }}%"></div>
                </div>
                <div class="relative flex gap-3 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
                    <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-info-500"></span>ارسال‌شده {{ fa_number($b['sent'] ?? 0) }}</span>
                    <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-info-300"></span>پیش‌نویس {{ fa_number($b['draft'] ?? 0) }}</span>
                    <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-info-200"></span>ناقص {{ fa_number($b['partial'] ?? 0) }}</span>
                </div>
            </div>

            {{-- فاکتورهای امروز --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-white/5 ring-1 ring-gray-950/5 dark:ring-white/10 p-5 flex flex-col gap-3 transition hover:ring-gray-400/30">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full bg-gray-400/10 blur-xl"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">فاکتورهای امروز</span>
                    <div class="rounded-lg bg-gray-400/10 p-1.5">
                        <x-heroicon-o-receipt-percent class="w-5 h-5 text-gray-400" />
                    </div>
                </div>
                <p class="relative text-2xl font-bold tracking-tight">
                    {{ fa_number($stats->todayInvoiceCount) }}
                    <span class="text-sm font-medium text-gray-400">فاکتور</span>
                </p>
                <div class="relative flex items-end gap-3" style="height: 44px;">
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full flex items-end" style="height: 44px;">
                            <div class="w-full rounded bg-info-500 transition-all duration-700" style="height: {{ $stats->todayBarPercent }}%"></div>
                        </div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">امروز</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full flex items-end" style="height: 44px;">
                            <div class="w-full rounded bg-gray-200 dark:bg-white/20 transition-all duration-700" style="height: {{ $stats->yesterdayBarPercent }}%"></div>
                        </div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">دیروز</span>
                    </div>
                </div>
                @if($stats->salesTrendPercent !== null)
                    <span class="relative text-xs font-medium {{ $stats->salesTrendPercent >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                        {{ $stats->salesTrendPercent >= 0 ? '+' : '' }}{{ fa_number($stats->salesTrendPercent, 1) }}٪ رشد
                    </span>
                @endif
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>