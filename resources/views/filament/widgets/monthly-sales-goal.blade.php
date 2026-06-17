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
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">پیشرفت هدف فروش این ماه</x-slot>

        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span class="font-medium">{{ number_format($data['achieved']) }} تومان</span>
                <span class="text-gray-500">از {{ number_format($data['goal']) }} تومان</span>
            </div>

            <div class="h-3 w-full rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div
                    class="h-3 rounded-full transition-all duration-700 ease-out"
                    style="width: {{ $data['percentage'] }}%; background-color: {{ $barColor }}"
                ></div>
            </div>

            <p class="text-xs text-gray-500">{{ $data['percentage'] }}٪ پیشرفت</p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>