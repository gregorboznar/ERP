<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Machine;

class MachineSelector extends Component
{
    public $machines;
    public $selectedMachine = '';

    public function mount()
    {
        $this->machines = Machine::all();
    }

    public function updatedSelectedMachine($value)
    {
        $this->dispatch('machine-selected', machineId: $value);
    }

    public function render()
    {
        return view('livewire.machine-selector');
    }
}
