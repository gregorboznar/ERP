@foreach($characteristics as $characteristic)
<div class="p-4 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors duration-200"
  wire:key="characteristic-{{ $characteristic->id }}">
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
          class="sr-only">
        <span @class([ 'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3' , 'bg-success-500/10 text-success-700 ring-1 ring-success-500/20'=> $data['characteristics'][$characteristic->id]['status'] ?? null === 'DA',
          'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50' => ($data['characteristics'][$characteristic->id]['status'] ?? null) !== 'DA',
          ])>
          <x-heroicon-m-check-circle class="w-4 h-4" />
          DA
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          name="data[characteristics][{{ $characteristic->id }}][status]"
          value="NE"
          wire:model="data.characteristics.{{ $characteristic->id }}.status"
          class="sr-only">
        <span @class([ 'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg mx-3' , 'bg-danger-500/10 text-danger-700 ring-1 ring-danger-500/20'=> $data['characteristics'][$characteristic->id]['status'] ?? null === 'NE',
          'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50' => ($data['characteristics'][$characteristic->id]['status'] ?? null) !== 'NE',
          ])>
          <x-heroicon-m-x-circle class="w-4 h-4" />
          NE
        </span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio"
          name="data[characteristics][{{ $characteristic->id }}][status]"
          value="N.O."
          wire:model="data.characteristics.{{ $characteristic->id }}.status"
          class="sr-only">
        <span @class([ 'inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg' , 'bg-warning-500/10 text-warning-700 ring-1 ring-warning-500/20'=> $data['characteristics'][$characteristic->id]['status'] ?? null === 'N.O.',
          'bg-gray-100 text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50' => ($data['characteristics'][$characteristic->id]['status'] ?? null) !== 'N.O.',
          ])>
          <x-heroicon-m-exclamation-circle class="w-4 h-4" />
          N.O.
        </span>
      </label>
    </div>
  </div>
</div>
@endforeach