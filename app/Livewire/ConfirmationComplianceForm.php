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
  public $selectedMachineId;
  public $selectedDate;
  public $correctTechnologicalParameters;
  public $editingRecord;
  public $isEditing = false;

  public function mount($productId, $editingRecord = null)
  {
    Log::info('Mounting ConfirmationComplianceForm with productId: ' . $productId);

    $this->productId = $productId;
    $this->product = Product::findOrFail($productId);
    $this->seriesTenders = SeriesTender::get();
    $this->machines = Machine::get();
    $this->editingRecord = $editingRecord;
    $this->isEditing = !is_null($editingRecord);
    
    if ($this->isEditing) {
      $this->selectedSeriesTenderId = $editingRecord->series_tender_id;
      $this->selectedMachineId = $editingRecord->machine_id ?? '';
      $this->selectedDate = $editingRecord->created_at->format('Y-m-d');
      $this->correctTechnologicalParameters = $editingRecord->correct_technological_parameters;
    } else {
      $this->selectedSeriesTenderId = '';
      $this->selectedMachineId = '';
      $this->selectedDate = now()->format('Y-m-d');
      $this->correctTechnologicalParameters = null;
    }


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

    // Initialize arrays with null values or load existing data
    foreach ($this->characteristics as $characteristic) {
      if ($this->isEditing) {
        $existingVisual = $this->editingRecord->visualCharacteristics()
          ->where('visual_characteristic_id', $characteristic->id)
          ->first();
        $this->visualCharacteristics[$characteristic->id] = $existingVisual 
          ? $this->mapComplianceValueToStatus($existingVisual->is_compliant) 
          : null;
      } else {
        $this->visualCharacteristics[$characteristic->id] = null;
      }
    }

    foreach ($this->measurementCharacteristicsList as $characteristic) {
      if ($this->isEditing) {
        $existingMeasurement = $this->editingRecord->measurementCharacteristics()
          ->where('measurement_characteristic_id', $characteristic->id)
          ->first();
        $this->measurementCharacteristics[$characteristic->id] = $existingMeasurement 
          ? $this->mapComplianceValueToStatus($existingMeasurement->is_compliant) 
          : null;
        
        // Load nest values if they exist
        $this->measurementValues[$characteristic->id] = [];
        if ($existingMeasurement && $this->product->nest_number > 0) {
          $nestValues = $existingMeasurement->measurementNestValues()->get();
          for ($i = 1; $i <= $this->product->nest_number; $i++) {
            $nestValue = $nestValues->where('nest_number', $i)->first();
            $this->measurementValues[$characteristic->id][$i] = $nestValue 
              ? $nestValue->measured_value 
              : null;
          }
        } elseif ($this->product->nest_number > 0) {
          for ($i = 1; $i <= $this->product->nest_number; $i++) {
            $this->measurementValues[$characteristic->id][$i] = null;
          }
        }
      } else {
        $this->measurementCharacteristics[$characteristic->id] = null;
        $this->measurementValues[$characteristic->id] = [];
        // Initialize measurement values for each nest
        if ($this->product->nest_number > 0) {
          for ($i = 1; $i <= $this->product->nest_number; $i++) {
            $this->measurementValues[$characteristic->id][$i] = null;
          }
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

  protected function mapComplianceValueToStatus($complianceValue)
  {
    return match ((int)$complianceValue) {
      0 => 2,  // 0 maps to NE
      1 => 1,  // 1 maps to DA
      2 => 3,  // 2 maps to N.O.
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

      if ($this->isEditing) {
        $confirmationCompliance = $this->editingRecord;
        $confirmationCompliance->update([
          'series_tender_id' => $this->selectedSeriesTenderId ?: null,
          'machine_id' => $this->selectedMachineId ?: null,
          'correct_technological_parameters' => $this->correctTechnologicalParameters,
        ]);
        
        // Delete existing characteristics to replace with new ones
        $confirmationCompliance->visualCharacteristics()->delete();
        $confirmationCompliance->measurementCharacteristics()->delete();
      } else {
        $confirmationCompliance = ConfirmationCompliance::create([
          'product_id' => $this->productId,
          'series_tender_id' => $this->selectedSeriesTenderId ?: null,
          'machine_id' => $this->selectedMachineId ?: null,
          'user_id' => $userId,
          'correct_technological_parameters' => $this->correctTechnologicalParameters,
        ]);
      }

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

          // Calculate the main measured_value (average of nest values or single value)
          $mainMeasuredValue = null;
          $validMeasurementValues = array_filter($measurementValues, fn($val) => !is_null($val));

          if (!empty($validMeasurementValues)) {
            if (count($validMeasurementValues) === 1) {
              $mainMeasuredValue = reset($validMeasurementValues);
            } else {
              $mainMeasuredValue = array_sum($validMeasurementValues) / count($validMeasurementValues);
            }
          }

          // Create the main measurement characteristic record
          $measurementCharacteristic = $confirmationCompliance->measurementCharacteristics()->create([
            'measurement_characteristic_id' => $characteristicId,
            'measured_value' => $mainMeasuredValue,
            'is_compliant' => $this->mapStatusToComplianceValue($value),
          ]);

          // Save nest measurements
          if (!empty($measurementValues)) {
            foreach ($measurementValues as $nestNumber => $measuredValue) {
              if (!is_null($measuredValue)) {
                $measurementCharacteristic->measurementNestValues()->create([
                  'nest_number' => $nestNumber,
                  'measured_value' => $measuredValue,
                ]);
              }
            }
          }
        }
      }

      DB::commit();

      $message = $this->isEditing 
        ? 'Confirmation compliance updated successfully.' 
        : 'Confirmation compliance saved successfully.';
      session()->flash('success', $message);
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
