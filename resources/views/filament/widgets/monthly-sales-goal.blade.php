@php
    $data = $this->getProgress();
    $colorMap = [
        'success' => '#22c55e',
        'warning' => '#f59e0b',
        'danger'  => '#ef4444',
        'primary' => '#6366f1',
        'info'    => '#3b82f6',
    ];
    $barColor = $colorMap[$data['color']] ?? '#6366f1';
    $remaining = max($data['goal'] - $data['achieved'], 0);
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">پیشرفت هدف فروش این ماه</x-slot>

        <div class="space-y-4">

            <div class="flex items-end justify-between">
                <div>
                    <p class="text-2xl font-bold tracking-tight" style="color: {{ $barColor }}">
                        {{ number_format($data['achieved']) }}
                        <span class="text-sm font-medium text-gray-400">تومان</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        از {{ number_format($data['goal']) }} تومان هدف
                    </p>
                </div>
                <div
                    class="text-sm font-bold px-2.5 py-1 rounded-lg"
                    style="background-color: {{ $barColor }}1a; color: {{ $barColor }}"
                >
                    {{ $data['percentage'] }}٪
                </div>
            </div>

            <div class="relative h-3 w-full rounded-full bg-gray-100 dark:bg-white/10 overflow-hidden">
                <div
                    class="absolute inset-y-0 right-0 rounded-full transition-all duration-700 ease-out"
                    style="width: {{ min($data['percentage'], 100) }}%; background: linear-gradient(to left, {{ $barColor }}, {{ $barColor }}cc);"
                ></div>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                @if($remaining > 0)
                    {{ number_format($remaining) }} تومان تا رسیدن به هدف باقیست
                @else
                    🎉 هدف این ماه محقق شد
                @endif
            </p>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
