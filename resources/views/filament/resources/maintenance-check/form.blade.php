<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
  <div class="space-y-6">
    {{-- Custom Form Content --}}
    <form wire:submit.prevent="create">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-950 dark:text-white">Title</label>
          <input type="text" wire:model="data.title" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-400 dark:focus:ring-primary-400">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-950 dark:text-white">Description</label>
          <textarea wire:model="data.description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-400 dark:focus:ring-primary-400"></textarea>
        </div>

        <!--   <div class="flex justify-end space-x-2">
          <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Save
          </button>
        </div> -->
      </div>
    </form>
  </div>
</div>