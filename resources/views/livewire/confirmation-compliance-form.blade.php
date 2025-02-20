<div>
  <form wire:submit="save">
    <div class="bg-white rounded-lg shadow w-full md:w-1/2">
      <div class="p-4 border-b border-gray-200">
        <p class="text-lg font-medium text-gray-900">Naziv: {{ $product->name }}</p>
      </div>
    </div>
    <div class="bg-white rounded-lg shadow w-full md:w-1/2">
      <div class="p-4 border-b border-gray-200">
        <p class="text-lg font-medium text-gray-900">Naziv: {{ $seriesTenders->name }}</p>
      </div>
    </div>
    <div class="space-y-6">
      <!-- Visual Characteristics -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Visual Characteristics</h3>
        </div>
        <div class="divide-y divide-gray-200">
          @foreach($characteristics as $characteristic)
          <div class="p-4 hover:bg-gray-50"
            wire:key="visual-{{ $characteristic->id }}"
            x-data="{ 
              selected: @entangle('visualCharacteristics.' . $characteristic->id).defer,
              updateValue(value) {
                this.selected = value;
                @this.updateCharacteristic('visual', {{ $characteristic->id }}, value);
              }
            }">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900">{{ $characteristic->name }}</h4>
              </div>
              <div class="ml-4 flex space-x-3">
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="visual_{{ $characteristic->id }}"
                    value="1"
                    class="sr-only"
                    :checked="selected == 1">
                  <span @click="updateValue(1)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-green-600 text-white': selected == 1,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 1
                    }">
                    <x-heroicon-m-check-circle class="w-4 h-4 inline-block" />
                    DA
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="visual_{{ $characteristic->id }}"
                    value="2"
                    class="sr-only"
                    :checked="selected == 2">
                  <span @click="updateValue(2)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-rose-600 text-white': selected == 2,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 2
                    }">
                    <x-heroicon-m-x-circle class="w-4 h-4 inline-block" />
                    NE
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="visual_{{ $characteristic->id }}"
                    value="3"
                    class="sr-only"
                    :checked="selected == 3">
                  <span @click="updateValue(3)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-yellow-500 text-white': selected == 3,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 3
                    }">
                    <x-heroicon-m-exclamation-circle class="w-4 h-4 inline-block" />
                    N.O.
                  </span>
                </label>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Measurement Characteristics -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Measurement Characteristics</h3>
        </div>
        <div class="divide-y divide-gray-200">
          @foreach($measurementCharacteristicsList as $characteristic)
          <div class="p-4 hover:bg-gray-50"
            wire:key="measurement-{{ $characteristic->id }}"
            x-data="{ 
              selected: @entangle('measurementCharacteristics.' . $characteristic->id).defer,
              updateValue(value) {
                this.selected = value;
                @this.updateCharacteristic('measurement', {{ $characteristic->id }}, value);
              }
            }">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900">{{ $characteristic->name }}</h4>
              </div>
              <div class="ml-4 flex space-x-3">
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="measurement_{{ $characteristic->id }}"
                    value="1"
                    class="sr-only"
                    :checked="selected == 1">
                  <span @click="updateValue(1)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-green-600 text-white': selected == 1,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 1
                    }">
                    <x-heroicon-m-check-circle class="w-4 h-4 inline-block" />
                    DA
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="measurement_{{ $characteristic->id }}"
                    value="2"
                    class="sr-only"
                    :checked="selected == 2">
                  <span @click="updateValue(2)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-rose-600 text-white': selected == 2,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 2
                    }">
                    <x-heroicon-m-x-circle class="w-4 h-4 inline-block" />
                    NE
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    name="measurement_{{ $characteristic->id }}"
                    value="3"
                    class="sr-only"
                    :checked="selected == 3">
                  <span @click="updateValue(3)"
                    :class="{
                      'px-3 py-1.5 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-150': true,
                      'bg-yellow-500 text-white': selected == 3,
                      'bg-gray-100 text-gray-700 hover:bg-gray-50': selected != 3
                    }">
                    <x-heroicon-m-exclamation-circle class="w-4 h-4 inline-block" />
                    N.O.
                  </span>
                </label>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="flex justify-end space-x-3">
        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
          Save Confirmation Compliance
        </button>
      </div>
    </div>
  </form>

  @if($errors->has('save'))
  <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
    {{ $errors->first('save') }}
  </div>
  @endif
</div>