<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800" x-data="{ activeTab: {{ $machines->first()->id ?? 'null' }} }">
            <x-filament::tabs>
                @foreach ($machines as $machine)
                <x-filament::tabs.item :icon="'heroicon-m-wrench-screwdriver'" x-on:click.prevent="activeTab = {{ $machine->id }}"
                    :href="'#tab-' . $machine->id" ::active="activeTab === {{ $machine->id }}"
                    x-bind:class="{
                            'fi-tabs-item-active': activeTab === {{ $machine->id }},
                            'fi-active': activeTab === {{ $machine->id }},
                            'ring-2 ring-primary-600': activeTab === {{ $machine->id }}
                        }">
                    {{ $machine->title }}
                </x-filament::tabs.item>
                @endforeach
            </x-filament::tabs>

            <div class="mb-4 flex items-center justify-between mt-4">
                <button wire:click="previousWeek"
                    class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none inline-flex gap-1 px-3 py-2 text-sm rounded-lg bg-gray-50 text-gray-950 hover:bg-gray-100 focus:bg-gray-100 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10 disabled:pointer-events-none disabled:opacity-70"
                    @if($currentWeek===-12) disabled @endif>
                    Previous Week
                </button>

                <div class="text-center">
                    <span class="font-semibold text-gray-950 dark:text-white">
                        {{ $startOfWeek->format('j.n.Y') }} - {{ $endOfWeek->format('j.n.Y') }}
                    </span>
                </div>

                <button wire:click="nextWeek"
                    class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none inline-flex gap-1 px-3 py-2 text-sm rounded-lg bg-gray-50 text-gray-950 hover:bg-gray-100 focus:bg-gray-100 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10 disabled:pointer-events-none disabled:opacity-70"
                    @if($currentWeek===12) disabled @endif>
                    Next Week
                </button>
            </div>

            <div class="mt-4">
                @foreach ($machines as $machine)
                <div id="tab-{{ $machine->id }}" class="space-y-4" x-show="activeTab === {{ $machine->id }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="w-full">
                        @if ($machine->maintenancePoints->count() > 0)
                        <div class="fi-ta-container overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                            <table class="w-full text-start text-sm">
                                <thead class="divide-y divide-gray-200 dark:divide-white/10">
                                    <tr class="bg-gray-50 dark:bg-white/5">
                                        <th class="fi-ta-header-cell px-3 py-3.5 text-left font-semibold text-gray-950 dark:text-white sm:first:ps-6">
                                            Maintenance Points
                                        </th>
                                        @php
                                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                        @endphp
                                        @foreach ($days as $index => $day)
                                        <th class="fi-ta-header-cell px-3 py-3.5 text-center font-semibold text-gray-950 dark:text-white">
                                            {{ $day }}
                                            <br>
                                            <small class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $startOfWeek->copy()->addDays($index)->format('d/m') }}
                                            </small>
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                                    @foreach ($machine->maintenancePoints as $point)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition duration-75">
                                        <td class="fi-ta-cell px-3 py-4 text-left font-medium text-gray-950 dark:text-white sm:first:ps-6">
                                            {{ $point->name }}
                                        </td>
                                        @for ($day = 0; $day < 7; $day++)
                                            <td class="fi-ta-cell px-3 py-4 text-center">
                                            @php
                                            $checkDate = $startOfWeek->copy()->addDays($day);
                                            $check = $machine->maintenanceChecks
                                            ->where('date', $checkDate->format('Y-m-d'))
                                            ->first();

                                            $checkPoint = $check?->maintenancePoints
                                            ->where('id', $point->id)
                                            ->first();
                                            @endphp
                                            @if ($checkPoint)
                                            @if ($checkPoint->pivot->checked)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-green-600 dark:bg-green-800/20 dark:text-green-400">
                                                <x-svg.heroicons.check-circle class="size-4" />
                                            </span>
                                            @else
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-800/20 dark:text-yellow-400">
                                                ⏳
                                            </span>
                                            @endif
                                            @else
                                            <span class="text-gray-400">-</span>
                                            @endif
                                            </td>
                                            @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="fi-empty-state p-6 text-center">
                            <div class="fi-empty-state-content">
                                <div class="text-gray-500 dark:text-gray-400">
                                    No maintenance points defined for {{ $machine->title }}
                                </div>
                            </div>
                        </div>
                        @endif
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