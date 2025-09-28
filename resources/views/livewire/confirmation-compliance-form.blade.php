<div>
    <div x-data="{ currentPage: 1 }">
   
        <form wire:submit="save">
            <!-- Page 1 - Basic Information -->
            <div x-show="currentPage === 1">
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex space-x-4">
                            <div class="bg-white rounded-lg shadow w-full md:w-1/2">
                                <div class="p-4">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ __('messages.title') }}: {{ $product->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg shadow w-full md:w-1/2">
                                <div class="p-4">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ __('messages.code') }}: {{ $product->code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="bg-white rounded-lg shadow w-full md:w-1/2">
                                <div class="p-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('messages.machine') }}:</span>
                                    <select wire:model="selectedMachineId"
                                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 filament-select text-sm font-medium">
                                        <option class="text-sm font-medium" value="">Izberi stroj</option>
                                        @foreach ($machines as $machine)
                                            <option class="text-sm font-medium" value="{{ $machine->id }}">
                                                {{ $machine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg shadow w-full md:w-1/2">
                                <div class="p-4  border-gray-200">
                                    <label for="date" class="text-sm font-medium text-gray-900">
                                        {{ __('messages.check_date') }}:
                                    </label>
                                    <input value="{{ $selectedDate }}" type="date" wire:model="selectedDate"
                                        id="date"
                                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm font-medium">
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="bg-white rounded-lg shadow w-full md:w-1/2">
                                <div class="p-4  border-gray-200">
                                    @if ($seriesTenders->count() > 0)
                                        <p class="text-sm font-medium text-gray-900">{{ __('messages.series') }}:</p>
                                        <select wire:model="selectedSeriesTenderId"
                                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 filament-select text-sm font-medium">
                                            <option class="text-sm font-medium" value="">
                                                {{ __('messages.select_series_tender') }}
                                            </option>
                                            @foreach ($seriesTenders as $seriesTender)
                                                <option class="text-sm font-medium" value="{{ $seriesTender->id }}">
                                                    {{ $seriesTender->series_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ __('messages.no_series_tenders_found') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-white rounded-lg shadow w-full">
                                <div class="p-4  flex justify-between items-center"
                                    x-data="{
                                        selected: @entangle('correctTechnologicalParameters').defer,
                                        updateValue(value) {
                                            this.selected = value;
                                            @this.set('correctTechnologicalParameters', value);
                                        }
                                    }">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ __('messages.correct_technological_parameters') }}:
                                    </p>
                                    <div class="mt-2 flex space-x-3">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="correct_technological_parameters" value="1"
                                                class="sr-only" x-model="selected">
                                            <span @click.prevent="updateValue(1)"
                                                x-bind:class="{ 'cursor-pointer': true }">
                                                <x-filament::badge :color="$correctTechnologicalParameters == 1 ? 'success' : 'gray'" :outline="$correctTechnologicalParameters != 1"
                                                    icon="heroicon-m-check-circle"
                                                    class="!min-w-[4.375rem] justify-center">
                                                    DA
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                        <label class="inline-flex items-center p-4">
                                            <input type="radio" name="correct_technological_parameters" value="2"
                                                class="sr-only" x-model="selected">
                                            <span @click.prevent="updateValue(2)"
                                                x-bind:class="{ 'cursor-pointer': true }">
                                                <x-filament::badge :color="$correctTechnologicalParameters == 2 ? 'danger' : 'gray'" :outline="$correctTechnologicalParameters != 2"
                                                    icon="heroicon-m-x-circle" class="!min-w-[4.375rem] justify-center">
                                                    NE
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="correct_technological_parameters" value="3"
                                                class="sr-only" x-model="selected">
                                            <span @click.prevent="updateValue(3)"
                                                x-bind:class="{ 'cursor-pointer': true }">
                                                <x-filament::badge :color="$correctTechnologicalParameters == 3 ? 'warning' : 'gray'" :outline="$correctTechnologicalParameters != 3"
                                                    icon="heroicon-m-exclamation-circle"
                                                    class="!min-w-[4.375rem] justify-center">
                                                    N.O.
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      <!-- Documentation Requirements Notice -->
                    <div class="mt-4 p-4 shadow border-blue-200 rounded-lg">
                        <h5 class="text-md font-semibold text-blue-900 mb-3">
                            Navodilo: Za preverjanje ustreznosti predpisanih zahtev uporabite sledeče dokumente:
                        </h5>
                        <div class="text-sm text-blue-800 space-y-2">
                            <p>VIZUALNE KARAKTERISTIKE – pripadajoči Kontrolni plan (QPXXX) in katalog napak</p>
                            <p>MERSKE KARAKTERISTIKE – pripadajoči Kontrolni plan (QPXXX)</p>
                            <p>TEHNOLOŠKI PARAMETRI – pripadajoči Tehnološki predpis (TPXXX)</p>
                            <p>N.O. – ni overjeno</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page 2 - Visual Characteristics -->
            <div x-show="currentPage === 2">
                <div class="p-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __('messages.visual_characteristics') }}
                            </h3>
                        </div>
                        <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto overflow-x-auto">
                            @foreach ($characteristics as $characteristic)
                                <div class="px-4 py-4 hover:bg-gray-50" wire:key="visual-{{ $characteristic->id }}"
                                    x-data="{
                                        selected: @entangle('visualCharacteristics.' . $characteristic->id).defer,
                                        updateValue(value) {
                                            this.selected = value;
                                            @this.updateCharacteristic('visual', {{ $characteristic->id }}, value);
                                        }
                                    }">
                                    <div class="flex items-center justify-between min-w-max">
                                        <div class="flex flex-1">
                                            <div class="flex items-center mr-4 min-w-[24rem]">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $characteristic->name }}</h4>
                                                @if ($characteristic->nominal_value)
                                                    <div class="text-xs text-gray-500 mt-1 ml-2">
                                                        Nominal: {{ $characteristic->nominal_value }}
                                                        {{ $characteristic->unit }}
                                                        @if ($characteristic->tolerance)
                                                            (±{{ $characteristic->tolerance }})
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4 flex space-x-3 flex-shrink-0">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="visual_{{ $characteristic->id }}"
                                                    value="1" class="sr-only" x-model="selected">
                                                <span @click.prevent="updateValue(1)"
                                                    x-bind:class="{
                                                        'cursor-pointer': true
                                                    }">
                                                    <x-filament::badge :color="$this->visualCharacteristics[$characteristic->id] == 1
                                                        ? 'success'
                                                        : 'gray'" :outline="$this->visualCharacteristics[$characteristic->id] != 1"
                                                        icon="heroicon-m-check-circle"
                                                        class="!min-w-[4.375rem] justify-center">
                                                        DA
                                                    </x-filament::badge>
                                                </span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="visual_{{ $characteristic->id }}"
                                                    value="2" class="sr-only" :checked="selected == 2">
                                                <span @click.prevent="updateValue(2)"
                                                    x-bind:class="{
                                                        'cursor-pointer': true
                                                    }">
                                                    <x-filament::badge :color="$this->visualCharacteristics[$characteristic->id] == 2
                                                        ? 'danger'
                                                        : 'gray'" :outline="$this->visualCharacteristics[$characteristic->id] != 2"
                                                        icon="heroicon-m-x-circle"
                                                        class="!min-w-[4.375rem] justify-center">
                                                        NE
                                                    </x-filament::badge>
                                                </span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="visual_{{ $characteristic->id }}"
                                                    value="3" class="sr-only" :checked="selected == 3">
                                                <span @click.prevent="updateValue(3)"
                                                    x-bind:class="{
                                                        'cursor-pointer': true
                                                    }">
                                                    <x-filament::badge :color="$this->visualCharacteristics[$characteristic->id] == 3
                                                        ? 'warning'
                                                        : 'gray'" :outline="$this->visualCharacteristics[$characteristic->id] != 3"
                                                        icon="heroicon-m-exclamation-circle"
                                                        class="!min-w-[4.375rem] justify-center">
                                                        N.O.
                                                    </x-filament::badge>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page 3 - Measurement Characteristics -->
            <div x-show="currentPage === 3">
                <div class="p-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('messages.measurement_characteristics') }}
                            </h3>
                        </div>
                        <div class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto">
                        <div class="flex justify-between p-4">
                            <div class="">
                                <span
                                    class="text-sm font-medium text-gray-900">{{ __('messages.measurement_characteristics_qkxxx') }}</span>
                            </div>
                            <div class="">
                                <span
                                    class="text-sm font-medium text-gray-900">{{ __('messages.measured_values') }}</span>
                            </div>
                            <div class="">
                                <span class="text-sm font-medium text-gray-900">{{ __('messages.status') }}</span>
                            </div>
                        </div>

                        @foreach ($measurementCharacteristicsList as $characteristic)
                            <div class="px-4 hover:bg-gray-50 py-2" wire:key="measurement-{{ $characteristic->id }}"
                                x-data="{
                                    selected: @entangle('measurementCharacteristics.' . $characteristic->id).defer,
                                    updateValue(value) {
                                        this.selected = value;
                                        @this.updateCharacteristic('measurement', {{ $characteristic->id }}, value);
                                    }
                                }">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-1">
                                        <div class="flex items-start mr-4 min-w-[24rem]">
                                            <h4 style="min-width: 260px;" class="text-sm font-medium text-gray-900 ">
                                                {{ $characteristic->name }}</h4>
                                            @if ($characteristic->nominal_value)
                                                <div class="text-xs text-gray-500 ml-2">
                                                    Nominal: {{ $characteristic->nominal_value }}
                                                    {{ $characteristic->unit }}
                                                    @if ($characteristic->tolerance)
                                                        (±{{ $characteristic->tolerance }})
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        @if ($product->nest_number > 0)
                                            <div class=" flex items-center space-x-2  pb-2">
                                                @for ($i = 1; $i <= $product->nest_number; $i++)
                                                    <div class="flex-none w-20">
                                                        <div class="relative p-2">
                                                            <input style="width: 80px;" type="text" step="0.0001"
                                                                wire:model="measurementValues.{{ $characteristic->id }}.{{ $i }}"
                                                                class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 border-gray-300 text-sm"
                                                                placeholder="{{ $characteristic->nominal_value ?? 'gn.' . $i }}">

                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex space-x-3">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="measurement_{{ $characteristic->id }}"
                                                value="1" class="sr-only" :checked="selected == 1">
                                            <span @click.prevent="updateValue(1)"
                                                x-bind:class="{
                                                    'cursor-pointer': true
                                                }">
                                                <x-filament::badge :color="$this->measurementCharacteristics[$characteristic->id] == 1
                                                    ? 'success'
                                                    : 'gray'" :outline="$this->measurementCharacteristics[$characteristic->id] != 1"
                                                    icon="heroicon-m-check-circle"
                                                    class="!min-w-[4.375rem] justify-center">
                                                    DA
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                        <label class="inline-flex items-center p-4">
                                            <input type="radio" name="measurement_{{ $characteristic->id }}"
                                                value="2" class="sr-only" :checked="selected == 2">
                                            <span @click.prevent="updateValue(2)"
                                                x-bind:class="{
                                                    'cursor-pointer': true
                                                }">
                                                <x-filament::badge :color="$this->measurementCharacteristics[$characteristic->id] == 2
                                                    ? 'danger'
                                                    : 'gray'" :outline="$this->measurementCharacteristics[$characteristic->id] != 2"
                                                    icon="heroicon-m-x-circle"
                                                    class="!min-w-[4.375rem] justify-center">
                                                    NE
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="measurement_{{ $characteristic->id }}"
                                                value="3" class="sr-only" :checked="selected == 3">
                                            <span @click.prevent="updateValue(3)"
                                                x-bind:class="{
                                                    'cursor-pointer': true
                                                }">
                                                <x-filament::badge :color="$this->measurementCharacteristics[$characteristic->id] == 3
                                                    ? 'warning'
                                                    : 'gray'" :outline="$this->measurementCharacteristics[$characteristic->id] != 3"
                                                    icon="heroicon-m-exclamation-circle"
                                                    class="!min-w-[4.375rem] justify-center">
                                                    N.O.
                                                </x-filament::badge>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-6 flex justify-between items-center">
            <!-- Back Button -->
            <button type="button" x-show="currentPage === 2" @click="currentPage = 1"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-semibold">
                Nazaj
            </button>
            <button type="button" x-show="currentPage === 3" @click="currentPage = 2"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-semibold">
                Nazaj
            </button>
            
            <div class="flex-1"></div>
            
            <!-- Forward/Submit Buttons -->
            <div class="flex space-x-3">
                <button type="button" x-show="currentPage === 1" @click="currentPage = 2"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-semibold">
                    Naprej na stran 2
                </button>
                <button type="button" x-show="currentPage === 2" @click="currentPage = 3"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-semibold">
                    Naprej na stran 3
                </button>
                <button type="submit" x-show="currentPage === 3"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-semibold">
                    @if($isEditing)
                        Posodobi
                    @else
                        Shrani
                    @endif
                </button>
            </div>
        </div>
        </form>

        @if ($errors->has('save'))
            <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                {{ $errors->first('save') }}
            </div>
        @endif

    </div>
</div>
