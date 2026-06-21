<x-filament-widgets::widget>
    <div class="relative overflow-hidden rounded-2xl ring-2 ring-danger-500 bg-danger-50 dark:bg-danger-950/40 p-4">

        <span class="absolute top-3 left-3 flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-danger-600"></span>
        </span>

        <div class="flex items-center gap-2 mb-3">
            <x-heroicon-o-fire class="w-6 h-6 text-danger-600 animate-pulse" />
            <h3 class="text-base font-bold text-danger-700 dark:text-danger-400">
                {{ $items->count() }} کالا با موجودی صفر — نیاز فوری به اقدام
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
            @foreach ($items as $item)
                <div class="flex items-center justify-between bg-white dark:bg-white/5 rounded-xl px-3 py-2 ring-1 ring-danger-500/20">
                    <span class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">
                        {{ $item->variant?->product?->name ?? 'کالای ناشناس' }}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0 mr-2">
                        {{ $item->warehouse?->name }}
                    </span>
                </div>
            @endforeach
        </div>

    </div>
</x-filament-widgets::widget>
