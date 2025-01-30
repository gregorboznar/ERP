<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::all();
        return view('machines.index', compact('machines'));
    }

    public function show(Machine $machine)
    {
        return view('machines.show', compact('machine'));
    }

    public function create()
    {
        return view('machines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'machine_type' => 'required|string',
            'type' => 'required|string',
            'year_of_manufacture' => 'required|integer',
            'manufacturer' => 'required|string',
            'control_period' => 'required|date',
            'title' => 'nullable|string',
        ]);

        Machine::create($validated);

        return redirect()->route('machines.index')
            ->with('success', 'Machine created successfully.');
    }

    public function edit(Machine $machine)
    {
        return view('machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'machine_type' => 'required|string',
            'type' => 'required|string',
            'year_of_manufacture' => 'required|integer',
            'manufacturer' => 'required|string',
            'control_period' => 'required|date',
            'title' => 'nullable|string',
        ]);

        $machine->update($validated);

        return redirect()->route('machines.index')
            ->with('success', 'Machine updated successfully.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('machines.index')
            ->with('success', 'Machine deleted successfully.');
    }
}
