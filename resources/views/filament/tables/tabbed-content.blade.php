<div class="space-y-6">
  <!-- Tab Navigation -->
  <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700">
    <button
      wire:click="$set('activeTab', 'all')"
      @class([ 'px-4 py-2 text-sm font-medium' , 'border-b-2 border-primary-600 text-primary-600'=> $activeTab === 'all',
      'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'all',
      ])
      >
      {{ __('All') }}
    </button>

    <button
      wire:click="$set('activeTab', 'active')"
      @class([ 'px-4 py-2 text-sm font-medium' , 'border-b-2 border-primary-600 text-primary-600'=> $activeTab === 'active',
      'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'active',
      ])
      >
      {{ __('Active') }}
    </button>

    <button
      wire:click="$set('activeTab', 'archived')"
      @class([ 'px-4 py-2 text-sm font-medium' , 'border-b-2 border-primary-600 text-primary-600'=> $activeTab === 'archived',
      'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'archived',
      ])
      >
      {{ __('Archived') }}
    </button>
  </div>

  <!-- Tab Content -->
  <div class="mt-6">
    @if ($activeTab === 'all')
    <div class="prose dark:prose-invert max-w-none">
      <h2>All Maintenance Checks</h2>
      <livewire:filament.tables.maintenance-checks-table :status="'all'" />
    </div>
    @elseif ($activeTab === 'active')
    <div class="prose dark:prose-invert max-w-none">
      <h2>Active Maintenance Checks</h2>
      <livewire:filament.tables.maintenance-checks-table :status="'active'" />
    </div>
    @else
    <div class="prose dark:prose-invert max-w-none">
      <h2>Archived Maintenance Checks</h2>
      <livewire:filament.tables.maintenance-checks-table :status="'archived'" />
    </div>
    @endif
  </div>
</div>