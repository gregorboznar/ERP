<x-filament-panels::page>
  <div class="space-y-6">
    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
      <h2 class="text-2xl font-bold mb-4">Maintenance Checks</h2>

      <div class="space-y-4">
        <!-- Add your custom maintenance checks content here -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div class="p-4 border rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Recent Checks</h3>
            <p class="text-gray-600 dark:text-gray-300">View and manage recent maintenance checks</p>
          </div>

          <div class="p-4 border rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Scheduled Maintenance</h3>
            <p class="text-gray-600 dark:text-gray-300">Upcoming scheduled maintenance tasks</p>
          </div>

          <div class="p-4 border rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Maintenance History</h3>
            <p class="text-gray-600 dark:text-gray-300">Historical maintenance records</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-filament-panels::page>