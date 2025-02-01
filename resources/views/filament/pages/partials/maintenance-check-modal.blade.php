@php
$machines = \App\Models\Machine::all();
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Machine Selection -->
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Machine</label>
            <select wire:model="data.machine_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                <option value="">Select a machine...</option>
                @foreach($machines as $machine)
                <option value="{{ $machine->id }}">{{ $machine->title }}</option>
                @endforeach
            </select>
            @error('data.machine_id') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
        </div>

        <!-- Check Date -->
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Check Date</label>
            <input type="date" wire:model="data.check_date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
            @error('data.check_date') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Check Type with Custom Styling -->
    <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Check Type</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach(['Routine', 'Preventive', 'Emergency'] as $type)
            <button type="button"
                wire:click="$set('data.check_type', '{{ $type }}')"
                class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium 
                               {{ isset($data['check_type']) && $data['check_type'] === $type 
                                  ? 'border-primary-500 bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' 
                                  : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                {{ $type }}
            </button>
            @endforeach
        </div>
        @error('data.check_type') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
    </div>

    <!-- Maintenance Points Section -->
    <div class="space-y-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Maintenance Points</h3>
        <div class="border dark:border-gray-700 rounded-lg divide-y dark:divide-gray-700">
            @foreach(\App\Models\MaintenancePoint::where('machine_id', $data['machine_id'] ?? null)->get() as $point)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                <div class="flex items-center space-x-4">
                    <input type="checkbox"
                        wire:model="data.maintenance_points.{{ $point->id }}"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $point->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $point->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Notes Section -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notes</label>
        <div class="mt-1">
            <textarea wire:model="data.notes" rows="3" class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md"></textarea>
        </div>
        @error('data.notes') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
    </div>
</div>