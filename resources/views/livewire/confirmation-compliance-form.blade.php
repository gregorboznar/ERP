<div>
  <form wire:submit="save">
    <div class="space-y-6">
      <!-- Visual Characteristics -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Visual Characteristics</h3>
        </div>
        <div class="divide-y divide-gray-200">
          @foreach($characteristics as $characteristic)
          <div class="p-4 hover:bg-gray-50" wire:key="visual-{{ $characteristic->id }}">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900">{{ $characteristic->name }}</h4>
              </div>
              <div class="ml-4 flex space-x-3">
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('visual', {{ $characteristic->id }}, 1)"
                    name="visual_{{ $characteristic->id }}"
                    value="1"
                    class="sr-only"
                    {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 1 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 1 ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
                    DA
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('visual', {{ $characteristic->id }}, 2)"
                    name="visual_{{ $characteristic->id }}"
                    value="2"
                    class="sr-only"
                    {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 2 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 2 ? 'bg-rose-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
                    NE
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('visual', {{ $characteristic->id }}, 3)"
                    name="visual_{{ $characteristic->id }}"
                    value="3"
                    class="sr-only"
                    {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 3 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($visualCharacteristics[$characteristic->id]) && $visualCharacteristics[$characteristic->id] == 3 ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
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
          <div class="p-4 hover:bg-gray-50" wire:key="measurement-{{ $characteristic->id }}">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900">{{ $characteristic->name }}</h4>
              </div>
              <div class="ml-4 flex space-x-3">
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('measurement', {{ $characteristic->id }}, 1)"
                    name="measurement_{{ $characteristic->id }}"
                    value="1"
                    class="sr-only"
                    {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 1 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 1 ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
                    DA
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('measurement', {{ $characteristic->id }}, 2)"
                    name="measurement_{{ $characteristic->id }}"
                    value="2"
                    class="sr-only"
                    {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 2 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 2 ? 'bg-rose-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
                    NE
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio"
                    wire:click="updateCharacteristic('measurement', {{ $characteristic->id }}, 3)"
                    name="measurement_{{ $characteristic->id }}"
                    value="3"
                    class="sr-only"
                    {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 3 ? 'checked' : '' }}>
                  <span class="px-3 py-1.5 text-sm font-medium rounded-lg {{ isset($measurementCharacteristics[$characteristic->id]) && $measurementCharacteristics[$characteristic->id] == 3 ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-50' }}">
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