<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.basic_information') }}</h3>
            <dl class="mt-2 space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.machine') }}</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $record->machine->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.date') }}</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">
                        @if(is_string($record->date))
                            {{ \Carbon\Carbon::parse($record->date)->format('d.m.Y') }}
                        @else
                            {{ $record->date->format('d.m.Y') }}
                        @endif
                    </dd>
                </div>
                @if($record->notes)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.notes') }}</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $record->notes }}</dd>
                </div>
                @endif
            </dl>
        </div>
        
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.maintenance_points') }}</h3>
            <div class="mt-2 space-y-2">
                @forelse($record->maintenancePoints as $point)
                    <div class="flex items-center space-x-2">
                        @if($point->pivot->checked)
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-600" />
                        @else
                            <x-heroicon-s-x-circle class="w-5 h-5 text-red-600" />
                        @endif
                        <span class="text-sm text-gray-900 dark:text-white">{{ $point->name }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.no_maintenance_points') }}</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="border-t pt-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.completion_status') }}</span>
                @php
                    $checkedCount = $record->maintenancePoints->where('pivot.checked', true)->count();
                    $totalCount = $record->maintenancePoints->count();
                    $percentage = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;
                @endphp
                <div class="mt-1">
                    <div class="flex items-center space-x-2">
                        <div class="flex-1 bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $checkedCount }}/{{ $totalCount }} ({{ $percentage }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
