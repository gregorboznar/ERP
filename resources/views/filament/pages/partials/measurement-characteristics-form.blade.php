@foreach($characteristics as $characteristic)
<div class="p-4 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors duration-200 border-t border-gray-200 dark:border-gray-600"
  wire:key="characteristic-{{ $characteristic->id }}"
  x-data="{ selected: '{{ $data['characteristics'][$characteristic->id]['status'] ?? '' }}' }">
  <div class="flex items-center">
    <div class="flex-1">
      <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
        {{ $characteristic->name }}
      </h4>
    </div>
    <div class="ml-4 flex space-x-3">
      <label class="inline-flex items-center">
        <input type="radio"
          name="data[characteristics][{{ $characteristic->id }}][status]"
          value="DA"
          wire:model="data.characteristics.{{ $characteristic->id }}.status"
          @change="selected = 'DA'"
          class="sr-only">
        <span
          @click="selected = 'DA'"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3 transition-all duration-200': true,
            'bg-green-600 text-white ring-2 ring-green-600 shadow-lg transform scale-105': selected === 'DA',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== 'DA'
          }">
          <x-heroicon-m-check-circle class="w-4 h-4" />
          DA
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          name="data[characteristics][{{ $characteristic->id }}][status]"
          value="NE"
          wire:model="data.characteristics.{{ $characteristic->id }}.status"
          @change="selected = 'NE'"
          class="sr-only">
        <span
          @click="selected = 'NE'"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3 transition-all duration-200': true,
            'bg-rose-600 text-white ring-2 ring-rose-600 shadow-lg transform scale-105': selected === 'NE',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== 'NE'
          }">
          <x-heroicon-m-x-circle class="w-4 h-4" />
          NE
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          name="data[characteristics][{{ $characteristic->id }}][status]"
          value="N.O."
          wire:model="data.characteristics.{{ $characteristic->id }}.status"
          @change="selected = 'N.O.'"
          class="sr-only">
        <span
          @click="selected = 'N.O.'"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200': true,
            'bg-yellow-500 text-white ring-2 ring-yellow-500 shadow-lg transform scale-105': selected === 'N.O.',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== 'N.O.'
          }">
          <x-heroicon-m-exclamation-circle class="w-4 h-4" />
          N.O.
        </span>
      </label>
    </div>
  </div>
</div>
@endforeach