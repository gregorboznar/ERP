@foreach($characteristics as $characteristic)
<div class="p-4 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors duration-200 border-t border-gray-200 dark:border-gray-600"
  wire:key="characteristic-{{ $characteristic->id }}"
  x-data="{ selected: '' }">
  <div class="flex items-center">
    <div class="flex-1">
      <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
        {{ $characteristic->name }}
      </h4>
    </div>
    <div class="ml-4 flex space-x-3">
      <label class="inline-flex items-center">
        <input type="radio"
          x-ref="daInput{{ $characteristic->id }}"
          wire:model="data.visual_characteristics.{{ $characteristic->id }}"
          name="visual_characteristics[{{ $characteristic->id }}]"
          value="1"
          @change="selected = '1'"
          class="sr-only">
        <span
          @click="selected = '1'; $refs.daInput{{ $characteristic->id }}.checked = true"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3 transition-all duration-200': true,
            'bg-green-600 text-white ring-2 ring-green-600 shadow-lg transform scale-105': selected === '1',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== '1'
          }">
          <x-heroicon-m-check-circle class="w-4 h-4" />
          DA
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          x-ref="neInput{{ $characteristic->id }}"
          wire:model="data.visual_characteristics.{{ $characteristic->id }}"
          name="visual_characteristics[{{ $characteristic->id }}]"
          value="2"
          @change="selected = '2'"
          class="sr-only">
        <span
          @click="selected = '2'; $refs.neInput{{ $characteristic->id }}.checked = true"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3 transition-all duration-200': true,
            'bg-rose-600 text-white ring-2 ring-rose-600 shadow-lg transform scale-105': selected === '2',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== '2'
          }">
          <x-heroicon-m-x-circle class="w-4 h-4" />
          NE
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          x-ref="noInput{{ $characteristic->id }}"
          wire:model="data.visual_characteristics.{{ $characteristic->id }}"
          name="visual_characteristics[{{ $characteristic->id }}]"
          value="3"
          @change="selected = '3'"
          class="sr-only">
        <span
          @click="selected = '3'; $refs.noInput{{ $characteristic->id }}.checked = true"
          :class="{
            'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200': true,
            'bg-yellow-500 text-white ring-2 ring-yellow-500 shadow-lg transform scale-105': selected === '3',
            'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50': selected !== '3'
          }">
          <x-heroicon-m-exclamation-circle class="w-4 h-4" />
          N.O.
        </span>
      </label>
    </div>
  </div>
</div>
@endforeach