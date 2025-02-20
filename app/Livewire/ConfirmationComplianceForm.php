<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ConfirmationCompliance;
use App\Models\VisualCharacteristic;
use App\Models\MeasurementCharacteristic;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SeriesTender;

class ConfirmationComplianceForm extends Component
{
  public $productId;
  public $product;
  public $visualCharacteristics = [];
  public $measurementCharacteristics = [];
  public $characteristics;
  public $measurementCharacteristicsList;
  public $seriesTenders;
  public function mount($productId)
  {
    Log::info('Mounting ConfirmationComplianceForm with productId: ' . $productId);

    $this->productId = $productId;
    $this->product = Product::findOrFail($productId);
    $this->seriesTenders = SeriesTender::where('product_id', $productId)->get();

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

  protected function mapStatusToComplianceValue($status)
  {
    return match ((int)$status) {
      2 => 0,  // NE maps to 0
      1 => 1,  // DA maps to 1
      3 => 2,  // N.O. maps to 2
      default => null,
    };
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
          $complianceValue = $this->mapStatusToComplianceValue($status);
          $confirmationCompliance->visualCharacteristics()->create([
            'visual_characteristic_id' => $id,
            'is_compliant' => $complianceValue,
            'notes' => null,
          ]);
          Log::info("Created visual characteristic", [
            'id' => $id,
            'status' => $status,
            'compliance_value' => $complianceValue
          ]);
        }
      }

      foreach ($this->measurementCharacteristics as $id => $status) {
        if ($status !== null) {
          $complianceValue = $this->mapStatusToComplianceValue($status);
          $confirmationCompliance->measurementCharacteristics()->create([
            'measurement_characteristic_id' => $id,
            'measured_value' => 0,
            'is_compliant' => $complianceValue,
            'notes' => null,
          ]);
          Log::info("Created measurement characteristic", [
            'id' => $id,
            'status' => $status,
            'compliance_value' => $complianceValue
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
