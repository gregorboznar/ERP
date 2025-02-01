<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">


            <x-filament::tabs>
                @foreach ($machines as $machine)
                    <x-filament::tabs.item :active="$loop->first" :icon="'heroicon-m-wrench-screwdriver'" :href="'#tab-' . $machine->id">
                        {{ $machine->title }}
                    </x-filament::tabs.item>
                @endforeach
            </x-filament::tabs>

            <div class="mt-4">
                @foreach ($machines as $machine)
                    <div id="tab-{{ $machine->id }}" class="space-y-4 {{ !$loop->first ? 'hidden' : '' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="p-4 border rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Recent Checks</h3>
                                <p class="text-gray-600 dark:text-gray-300">View and manage recent maintenance checks for
                                    {{ $machine->title }}</p>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Scheduled Maintenance</h3>
                                <p class="text-gray-600 dark:text-gray-300">Upcoming scheduled maintenance tasks for
                                    {{ $machine->title }}</p>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Maintenance History</h3>
                                <p class="text-gray-600 dark:text-gray-300">Historical maintenance records for
                                    {{ $machine->title }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('[x-filament\\:tabs] [role="tab"]');
                const panels = document.querySelectorAll('[id^="tab-"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();
                        const target = tab.getAttribute('href').substring(1);

                        // Hide all panels
                        panels.forEach(panel => {
                            panel.classList.add('hidden');
                        });

                        // Show the target panel
                        document.getElementById(target).classList.remove('hidden');

                        // Update active state of tabs
                        tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
                        tab.setAttribute('aria-selected', 'true');
                    });
                });
            });
        </script>
    @endpush
</x-filament-panels::page>
