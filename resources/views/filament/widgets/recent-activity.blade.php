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

        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($this->getActivities() as $activity)
                <div class="flex items-center gap-3 py-2.5 px-1 hover:bg-gray-50 dark:hover:bg-white/5 transition rounded-lg group">

                    {{-- آیکون --}}
                    <div @class([
                        'flex items-center justify-center w-9 h-9 rounded-xl shrink-0 transition',
                        'bg-success-100 dark:bg-success-900/40 text-success-600 dark:text-success-400' => $activity['color'] === 'success',
                        'bg-danger-100 dark:bg-danger-900/40 text-danger-600 dark:text-danger-400'   => $activity['color'] === 'danger',
                        'bg-warning-100 dark:bg-warning-900/40 text-warning-600 dark:text-warning-400' => $activity['color'] === 'warning',
                        'bg-info-100 dark:bg-info-900/40 text-info-600 dark:text-info-400'           => $activity['color'] === 'info',
                        'bg-primary-100 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400' => $activity['color'] === 'primary',
                    ])>
                        <x-filament::icon :icon="$activity['icon']" class="w-4 h-4" />
                    </div>

                    {{-- متن --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-0.5">
                            {{ $activity['label'] }}
                        </p>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">
                            {{ $activity['text'] }}
                        </p>
                    </div>

                    {{-- زمان --}}
                    <div class="shrink-0 text-left">
                        <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                            {{ $activity['time']->diffForHumans() }}
                        </span>
                    </div>

                </div>
            @endforeach

            @if($this->getActivities()->isEmpty())
                <div class="py-8 text-center text-sm text-gray-400">
                    <x-filament::icon icon="heroicon-o-inbox" class="w-8 h-8 mx-auto mb-2 opacity-40" />
                    فعالیتی ثبت نشده
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>