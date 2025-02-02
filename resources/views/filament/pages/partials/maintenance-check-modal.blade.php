<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Machine Selection -->
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Machine</label>
            <div wire:ignore x-data="{
                init() {
                    Livewire.on('machine-selected', (event) => {
                        console.log('Machine selected:', event);
                        @this.set('data.machine_id', event[0].machineId).then(() => {
                            Livewire.dispatch('maintenance-points-updated');
                        });
                    })
                }
            }" class="w-full">
                <livewire:machine-selector />
                @error('data.machine_id')
                    <p class="mt-1 text-sm text-danger-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Check Date -->
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Check Date</label>
            <input type="date" wire:model="data.check_date"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
            @error('data.check_date')
                <p class="mt-1 text-sm text-danger-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Maintenance Points Section -->
    <div class="space-y-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Maintenance Points</h3>
        <div class="border dark:border-gray-700 rounded-lg divide-y dark:divide-gray-700">
            @if (isset($data['machine_id']) && $data['machine_id'])
                @php
                    $machine = \App\Models\Machine::with('maintenancePoints')->find($data['machine_id']);
                @endphp
                @if ($machine && $machine->maintenancePoints->count() > 0)
                    @foreach ($machine->maintenancePoints as $point)
                        <div class="p-4 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors duration-200"
                            wire:key="point-{{ $point->id }}">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $point->name }}
                                    </h4>
                                    @if ($point->description)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $point->description }}</p>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <input type="checkbox" wire:model="data.maintenance_points.{{ $point->id }}"
                                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 text-sm text-gray-500 dark:text-gray-400">
                        No maintenance points found for this machine.
                    </div>
                @endif
            @else
                <div class="p-4 text-sm text-gray-500 dark:text-gray-400">
                    Select a machine to view maintenance points.
                </div>
            @endif
        </div>
        @error('data.maintenance_points')
            <p class="mt-1 text-sm text-danger-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Notes -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notes</label>
        <textarea wire:model="data.notes" rows="3"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
            placeholder="Add any additional notes here..."></textarea>
        @error('data.notes')
            <p class="mt-1 text-sm text-danger-500">{{ $message }}</p>
        @enderror
    </div>
</div>
