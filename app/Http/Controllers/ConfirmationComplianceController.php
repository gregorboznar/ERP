<?php

namespace App\Http\Controllers;

use App\Models\ConfirmationCompliance;
use App\Models\VisualCharacteristic;
use App\Models\MeasurementCharacteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfirmationComplianceController extends Controller
{
  public function store(Request $request)
  {
    try {
      Log::info('Received request data:', $request->all());

      DB::beginTransaction();

      // Validate the request
      $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'visual_characteristics' => 'array',
        'visual_characteristics.*' => 'required|in:1,2,3',
        'measurement_characteristics' => 'array',
        'measurement_characteristics.*' => 'required|in:1,2,3',
      ]);

      Log::info('Validated data:', $validated);

      // Create the confirmation compliance record
      $confirmationCompliance = ConfirmationCompliance::create([
        'product_id' => $validated['product_id'],
      ]);

      Log::info('Created confirmation compliance:', ['id' => $confirmationCompliance->id]);

      // Handle visual characteristics
      if (!empty($validated['visual_characteristics'])) {
        foreach ($validated['visual_characteristics'] as $characteristicId => $status) {
          $isCompliant = (int)$status === 1;
          $created = $confirmationCompliance->visualCharacteristics()->create([
            'visual_characteristic_id' => $characteristicId,
            'is_compliant' => $isCompliant,
            'notes' => null,
          ]);

          Log::info("Created visual characteristic:", [
            'id' => $characteristicId,
            'status' => $status,
            'is_compliant' => $isCompliant,
            'created_id' => $created->id
          ]);
        }
      }

      // Handle measurement characteristics
      if (!empty($validated['measurement_characteristics'])) {
        foreach ($validated['measurement_characteristics'] as $characteristicId => $status) {
          $isCompliant = (int)$status === 1;
          $created = $confirmationCompliance->measurementCharacteristics()->create([
            'measurement_characteristic_id' => $characteristicId,
            'measured_value' => 0,
            'is_compliant' => $isCompliant,
            'notes' => null,
          ]);

          Log::info("Created measurement characteristic:", [
            'id' => $characteristicId,
            'status' => $status,
            'is_compliant' => $isCompliant,
            'created_id' => $created->id
          ]);
        }
      }

      DB::commit();

      $confirmationCompliance->load('visualCharacteristics', 'measurementCharacteristics');

      Log::info('Successfully created confirmation compliance with relationships', [
        'id' => $confirmationCompliance->id,
        'visual_count' => $confirmationCompliance->visualCharacteristics->count(),
        'measurement_count' => $confirmationCompliance->measurementCharacteristics->count()
      ]);

      return response()->json([
        'message' => 'Confirmation compliance created successfully',
        'data' => $confirmationCompliance
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error creating confirmation compliance: ' . $e->getMessage());
      Log::error('Stack trace: ' . $e->getTraceAsString());

      return response()->json([
        'message' => 'Error creating confirmation compliance',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
