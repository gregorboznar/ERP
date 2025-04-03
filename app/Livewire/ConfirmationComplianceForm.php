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
use App\Models\Machine;
use Filament\Facades\Filament;

class ConfirmationComplianceForm extends Component
{
  public $productId;
  public $product;
  public $visualCharacteristics = [];
  public $measurementCharacteristics = [];
  public $measurementValues = [];
  public $characteristics;
  public $measurementCharacteristicsList;
  public $seriesTenders;
  public $machines;
  public $selectedSeriesTenderId;
  public $selectedDate;
  public $correctTechnologicalParameters;

  public function mount($productId)
  {
    Log::info('Mounting ConfirmationComplianceForm with productId: ' . $productId);

    $this->productId = $productId;
    $this->product = Product::findOrFail($productId);
    $this->seriesTenders = SeriesTender::get();
    $this->machines = Machine::get();
    $this->selectedSeriesTenderId = '';
    $this->selectedDate = now()->format('Y-m-d');


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
      $this->measurementValues[$characteristic->id] = [];
      // Initialize measurement values for each nest
      if ($this->product->nest_number > 0) {
        for ($i = 1; $i <= $this->product->nest_number; $i++) {
          $this->measurementValues[$characteristic->id][$i] = null;
        }
      }
    }

    Log::info('Product ID: ' . $productId);
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
    try {
      DB::beginTransaction();
      $userId = auth('web')->id();
      if (!$userId) {
        throw new \Exception('User is not authenticated');
      }

      $confirmationCompliance = ConfirmationCompliance::create([
        'product_id' => $this->productId,
        'series_tender_id' => $this->selectedSeriesTenderId,
        'user_id' => $userId,
        'correct_technological_parameters' => $this->correctTechnologicalParameters,
      ]);

      // Save visual characteristics
      foreach ($this->visualCharacteristics as $characteristicId => $value) {
        if (!is_null($value)) {
          $confirmationCompliance->visualCharacteristics()->create([
            'visual_characteristic_id' => $characteristicId,
            'is_compliant' => $this->mapStatusToComplianceValue($value),
          ]);
        }
      }

      // Save measurement characteristics with nest values
      foreach ($this->measurementCharacteristics as $characteristicId => $value) {
        if (!is_null($value)) {
          $measurementValues = $this->measurementValues[$characteristicId] ?? [];

          // Create the main measurement characteristic record
          $measurementCharacteristic = $confirmationCompliance->measurementCharacteristics()->create([
            'measurement_characteristic_id' => $characteristicId,
            'is_compliant' => $this->mapStatusToComplianceValue($value),
          ]);

          // Save nest measurements
          if (!empty($measurementValues)) {
            foreach ($measurementValues as $nestNumber => $measuredValue) {
              if (!is_null($measuredValue)) {
                DB::table('confirmation_compliance_measurement_nest_values')->insert([
                  'confirmation_compliance_measurement_characteristic_id' => $measurementCharacteristic->id,
                  'nest_number' => $nestNumber,
                  'measured_value' => $measuredValue,
                  'created_at' => now(),
                  'updated_at' => now(),
                ]);
              }
            }
          }
        }
      }

      DB::commit();

      session()->flash('success', 'Confirmation compliance saved successfully.');
      return redirect()->route('filament.admin.resources.products.confirmation-compliance', ['record' => $this->productId]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error saving confirmation compliance: ' . $e->getMessage());
      $this->addError('save', 'Failed to save confirmation compliance. Please try again.');
    }
  }

  public function render()
  {
    return view('livewire.confirmation-compliance-form');
  }
}
