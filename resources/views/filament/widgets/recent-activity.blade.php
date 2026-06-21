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

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($this->getActivities() as $activity)
                <div class="rounded-2xl bg-gray-50 dark:bg-white/5 ring-1 ring-gray-950/5 dark:ring-white/10 p-5 flex flex-col gap-2 hover:ring-gray-950/10 dark:hover:ring-white/20 transition min-h-[148px]">

                    <div class="flex items-center justify-between">
                        <div @class([
                            'flex items-center justify-center w-9 h-9 rounded-xl shrink-0',
                            'bg-success-100 dark:bg-success-900/40 text-success-600 dark:text-success-400' => $activity['color'] === 'success',
                            'bg-danger-100 dark:bg-danger-900/40 text-danger-600 dark:text-danger-400'   => $activity['color'] === 'danger',
                            'bg-warning-100 dark:bg-warning-900/40 text-warning-600 dark:text-warning-400' => $activity['color'] === 'warning',
                            'bg-info-100 dark:bg-info-900/40 text-info-600 dark:text-info-400'           => $activity['color'] === 'info',
                            'bg-primary-100 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400' => $activity['color'] === 'primary',
                        ])>
                            <x-filament::icon :icon="$activity['icon']" class="w-4 h-4" />
                        </div>
                        <span class="text-[11px] text-gray-400 dark:text-gray-500 whitespace-nowrap">
                            {{ $activity['time']->diffForHumans() }}
                        </span>
                    </div>

                    <p @class([
                        'text-[11px] font-semibold tracking-wide mt-1',
                        'text-success-600 dark:text-success-400' => $activity['color'] === 'success',
                        'text-danger-600 dark:text-danger-400'   => $activity['color'] === 'danger',
                        'text-warning-600 dark:text-warning-400' => $activity['color'] === 'warning',
                        'text-info-600 dark:text-info-400'       => $activity['color'] === 'info',
                        'text-primary-600 dark:text-primary-400' => $activity['color'] === 'primary',
                    ])>
                        {{ $activity['label'] }}
                    </p>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-100 line-clamp-2">
                        {{ $activity['text'] }}
                    </p>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-sm text-gray-400">
                    <x-filament::icon icon="heroicon-o-inbox" class="w-9 h-9 mx-auto mb-2 opacity-30" />
                    فعالیتی ثبت نشده
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
