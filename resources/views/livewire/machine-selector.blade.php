<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Machine Selection -->
        <div class="col-span-1">
            <div>
                <select wire:model="selectedMachine" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option value="">Select a machine...</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
