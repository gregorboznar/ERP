<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Machine;

class MachineSelector extends Component
{
    public $machines;
    public $selectedMachine = '';
    public $selectedMachineId = null;

    public function mount($selectedMachineId = null)
    {
        $this->machines = Machine::all();
        $this->selectedMachineId = $selectedMachineId;
        $this->selectedMachine = $selectedMachineId ?? '';
    }

    public function updatedSelectedMachine($value)
    {
        $this->dispatch('machine-selected', ['machineId' => $value]);
    }

    public function render()
    {
        return view('livewire.machine-selector');
    }
}
