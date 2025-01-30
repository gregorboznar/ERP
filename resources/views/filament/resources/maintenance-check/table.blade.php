<div class="fi-ta-ctn p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
  <div class="space-y-6">
    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
      <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        <button
          x-data="{}"
          x-on:click="$dispatch('change-tab', 'tab1')"
          x-bind:class="{'border-primary-500 text-primary-600': $store.currentTab === 'tab1', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': $store.currentTab !== 'tab1'}"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          role="tab">
          Tab 1
        </button>

        <button
          x-data="{}"
          x-on:click="$dispatch('change-tab', 'tab2')"
          x-bind:class="{'border-primary-500 text-primary-600': $store.currentTab === 'tab2', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': $store.currentTab !== 'tab2'}"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          role="tab">
          Tab 2
        </button>

        <button
          x-data="{}"
          x-on:click="$dispatch('change-tab', 'tab3')"
          x-bind:class="{'border-primary-500 text-primary-600': $store.currentTab === 'tab3', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': $store.currentTab !== 'tab3'}"
          class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
          role="tab">
          Tab 3
        </button>
      </nav>
    </div>

    {{-- Tab Contents --}}
    <div x-data="{ currentTab: 'tab1' }" x-on:change-tab.window="currentTab = $event.detail">
      {{-- Tab 1 Content --}}
      <div x-show="currentTab === 'tab1'" class="space-y-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tab 1 Content</h3>
          <p class="mt-2 text-gray-500 dark:text-gray-400">Content for tab 1 goes here.</p>
        </div>
      </div>

      {{-- Tab 2 Content --}}
      <div x-show="currentTab === 'tab2'" class="space-y-4" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tab 2 Content</h3>
          <p class="mt-2 text-gray-500 dark:text-gray-400">Content for tab 2 goes here.</p>
        </div>
      </div>

      {{-- Tab 3 Content --}}
      <div x-show="currentTab === 'tab3'" class="space-y-4" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tab 3 Content</h3>
          <p class="mt-2 text-gray-500 dark:text-gray-400">Content for tab 3 goes here.</p>
        </div>
      </div>
    </div>
  </div>
</div>