<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ConfirmationCompliance;
use App\Models\VisualCharacteristic;
use App\Models\MeasurementCharacteristic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfirmationComplianceForm extends Component
{
  public $productId;
  public $visualCharacteristics = [];
  public $measurementCharacteristics = [];
  public $characteristics;
  public $measurementCharacteristicsList;

  public function mount($productId)
  {
    Log::info('Mounting ConfirmationComplianceForm with productId: ' . $productId);

    $this->productId = $productId;

    // Initialize visual characteristics
    $this->characteristics = VisualCharacteristic::whereIn('id', function ($query) {
      $query->select('visual_characteristic_id')
        ->from('product_visual_characteristics')
        ->where('product_id', $this->productId);
    })->get();

    Log::info('Loaded visual characteristics:', ['count' => $this->characteristics->count()]);

    // Initialize measurement characteristics
    $this->measurementCharacteristicsList = MeasurementCharacteristic::whereIn('id', function ($query) {
      $query->select('measurement_characteristic_id')
        ->from('product_measurement_characteristics')
        ->where('product_id', $this->productId);
    })->get();

    Log::info('Loaded measurement characteristics:', ['count' => $this->measurementCharacteristicsList->count()]);

    // Initialize arrays with null values
    foreach ($this->characteristics as $characteristic) {
      $this->visualCharacteristics[$characteristic->id] = null;
    }

    foreach ($this->measurementCharacteristicsList as $characteristic) {
      $this->measurementCharacteristics[$characteristic->id] = null;
    }
  }

  public function updateCharacteristic($type, $id, $value)
  {
    Log::info("Updating characteristic", ['type' => $type, 'id' => $id, 'value' => $value]);

    if ($type === 'visual') {
      $this->visualCharacteristics[$id] = (int)$value;
    } else {
      $this->measurementCharacteristics[$id] = (int)$value;
    }
  }

  public function save()
  {
    Log::info('Saving form with data:', [
      'visual' => $this->visualCharacteristics,
      'measurement' => $this->measurementCharacteristics
    ]);

    try {
      DB::beginTransaction();

      $confirmationCompliance = ConfirmationCompliance::create([
        'product_id' => $this->productId,
      ]);

      foreach ($this->visualCharacteristics as $id => $status) {
        if ($status !== null) {
          $confirmationCompliance->visualCharacteristics()->create([
            'visual_characteristic_id' => $id,
            'is_compliant' => $status == 1,
            'notes' => null,
          ]);
        }
      }

      foreach ($this->measurementCharacteristics as $id => $status) {
        if ($status !== null) {
          $confirmationCompliance->measurementCharacteristics()->create([
            'measurement_characteristic_id' => $id,
            'measured_value' => 0,
            'is_compliant' => $status == 1,
            'notes' => null,
          ]);
        }
      }

      DB::commit();

      $this->dispatch('confirmation-saved', confirmationId: $confirmationCompliance->id);

      return redirect()->route('filament.admin.resources.products.confirmation-compliance', ['record' => $this->productId]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error saving confirmation compliance: ' . $e->getMessage());
      Log::error('Stack trace: ' . $e->getTraceAsString());
      $this->addError('save', 'Error saving confirmation compliance: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.confirmation-compliance-form');
  }
}
