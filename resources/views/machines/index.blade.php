<div class="fi-ta-ctn p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
  <div class="space-y-6">
    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
      <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
        @foreach($machines as $machine)
        <button
          x-data="{}"
          x-on:click="$dispatch('change-tab', 'machine-{{ $machine->id }}')"
          x-bind:class="{'border-primary-500 text-primary-600': $store.currentTab === 'machine-{{ $machine->id }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': $store.currentTab !== 'machine-{{ $machine->id }}'}"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          role="tab">
          {{ $machine->getName() }}
        </button>
        @endforeach
      </nav>
    </div>

    {{-- Tab Contents --}}
    <div x-data="{ currentTab: 'machine-{{ $machines->first()->id ?? '' }}' }" x-on:change-tab.window="currentTab = $event.detail">
      @foreach($machines as $machine)
      <div x-show="currentTab === 'machine-{{ $machine->id }}'" class="space-y-4" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $machine->getName() }}</h3>
          <div class="mt-2 text-gray-500 dark:text-gray-400">
            <p><strong>Type:</strong> {{ $machine->machine_type }}</p>
            <p><strong>Manufacturer:</strong> {{ $machine->manufacturer }}</p>
            <p><strong>Year:</strong> {{ $machine->year_of_manufacture }}</p>
            <p><strong>Control Period:</strong> {{ $machine->control_period?->format('Y-m-d') }}</p>
            {{-- Add more machine details as needed --}}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>