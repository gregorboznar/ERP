<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TemperatureChart extends Component
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('components.temperature-chart');
    }
}
