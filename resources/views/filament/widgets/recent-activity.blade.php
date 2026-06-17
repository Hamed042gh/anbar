<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-success-500"></span>
                </span>
                فعالیت‌های اخیر
            </div>
        </x-slot>

        <div class="space-y-3">
            @foreach ($this->getActivities() as $activity)
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <div @class([
                        'flex items-center justify-center w-8 h-8 rounded-full',
                        'bg-success-100 dark:bg-success-900 text-success-600 dark:text-success-400' => $activity['color'] === 'success',
                        'bg-danger-100 dark:bg-danger-900 text-danger-600 dark:text-danger-400' => $activity['color'] === 'danger',
                        'bg-warning-100 dark:bg-warning-900 text-warning-600 dark:text-warning-400' => $activity['color'] === 'warning',
                        'bg-info-100 dark:bg-info-900 text-info-600 dark:text-info-400' => $activity['color'] === 'info',
                        'bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400' => $activity['color'] === 'primary',
                    ])>
                        <x-filament::icon :icon="$activity['icon']" class="w-4 h-4" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $activity['text'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time']->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>