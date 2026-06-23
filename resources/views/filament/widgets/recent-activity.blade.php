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

        <div class="flex flex-col divide-y divide-gray-100 dark:divide-white/5">
            @forelse ($this->getActivities() as $activity)
                <div class="flex items-center gap-3 py-3 first:pt-0 last:pb-0 group">

                    {{-- آیکون --}}
                    <div @class([
                        'flex items-center justify-center w-8 h-8 rounded-lg shrink-0 transition',
                        'bg-success-50 dark:bg-success-900/30 text-success-500 dark:text-success-400' => $activity['color'] === 'success',
                        'bg-danger-50 dark:bg-danger-900/30 text-danger-500 dark:text-danger-400'     => $activity['color'] === 'danger',
                        'bg-warning-50 dark:bg-warning-900/30 text-warning-500 dark:text-warning-400' => $activity['color'] === 'warning',
                        'bg-info-50 dark:bg-info-900/30 text-info-500 dark:text-info-400'             => $activity['color'] === 'info',
                        'bg-primary-50 dark:bg-primary-900/30 text-primary-500 dark:text-primary-400' => $activity['color'] === 'primary',
                    ])>
                        <x-filament::icon :icon="$activity['icon']" class="w-4 h-4" />
                    </div>

                    {{-- متن --}}
                    <div class="flex-1 min-w-0">
                        <p @class([
                            'text-[11px] font-semibold leading-none mb-1',
                            'text-success-600 dark:text-success-400' => $activity['color'] === 'success',
                            'text-danger-600 dark:text-danger-400'   => $activity['color'] === 'danger',
                            'text-warning-600 dark:text-warning-400' => $activity['color'] === 'warning',
                            'text-info-600 dark:text-info-400'       => $activity['color'] === 'info',
                            'text-primary-600 dark:text-primary-400' => $activity['color'] === 'primary',
                        ])>{{ $activity['label'] }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-200 truncate">
                            {{ $activity['text'] }}
                        </p>
                    </div>

                    {{-- زمان --}}
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 whitespace-nowrap shrink-0">
                        {{ $activity['time']->diffForHumans() }}
                    </span>

                </div>
            @empty
                <div class="py-10 text-center text-sm text-gray-400">
                    <x-filament::icon icon="heroicon-o-inbox" class="w-9 h-9 mx-auto mb-2 opacity-30" />
                    فعالیتی ثبت نشده
                </div>
            @endforelse
        </div>

    </x-filament::section>
</x-filament-widgets::widget>