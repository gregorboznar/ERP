<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Machine Selection -->
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Machine</label>
            <div x-data="{
                init() {
                    Livewire.on('machine-selected', ({ machineId }) => {
                        @this.set('data.machine_id', machineId);
                    });
                }
            }
            }">
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
            @if(isset($data['machine_id']))
                @foreach(\App\Models\Machine::find($data['machine_id'])->maintenancePoints as $point)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" wire:model="data.maintenance_points.{{ $point->id }}"
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $point->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $point->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-4 text-gray-500 dark:text-gray-400">
                    Please select a machine to view its maintenance points.
                </div>
            @endif
        </div>
    </div>

    <!-- Notes Section -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notes</label>
        <div class="mt-1">
            <textarea wire:model="data.notes" rows="3"
                class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md"></textarea>
        </div>
        @error('data.notes')
            <p class="mt-1 text-sm text-danger-500">{{ $message }}</p>
        @enderror
    </div>
</div>
