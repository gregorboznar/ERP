<?php

namespace App\Filament\Exports;

use App\Models\ScpMeasurement;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;

class ScpMeasurementTemplateExporter extends Exporter
{
  protected $templatePath;

  public function __construct(Export $export, array $columnMap = [], array $options = [])
  {
    parent::__construct($export, $columnMap, $options);
    $this->templatePath = storage_path('app/templates/scp-template2.xlsx');
  }

  public static function getColumns(): array
  {
    return [
      ExportColumn::make('datetime')
        ->label(__('messages.datetime')),
      ExportColumn::make('user')
        ->label(__('messages.operator')),
      ExportColumn::make('series')
        ->label(__('messages.series_number')),
      ExportColumn::make('product')
        ->label(__('messages.product_name')),
      ExportColumn::make('measurements')
        ->label(__('messages.measurements')),
    ];
  }

  public function getFileName(Export $export): string
  {
    // If the export already has a filename that includes our new pattern, use it
    if (strpos($export->file_name, 'scp-template-export-') === 0) {
      return $export->file_name;
    }

    // Otherwise, ensure we use the new naming pattern
    return 'scp-template-export-' . now()->format('Y-m-d-H-i-s');
  }

  public function getFileExtension(): string
  {
    return 'xlsx';
  }

  public function getFileDisk(): string
  {
    return 'local';
  }

  public function getFileDirectory(): string
  {
    return 'filament_exports/' . $this->export->getKey();
  }

  public static function getCompletedNotificationBody(Export $export): string
  {
    return __('messages.export_completed', ['count' => $export->successful_rows]);
  }

  public function handle(): void
  {
    // Create the export directory if it doesn't exist
    $exportDirectory = $this->getFileDirectory();
    if (!Storage::exists($exportDirectory)) {
      Storage::makeDirectory($exportDirectory);
    }

    // Path for the final export file
    $exportPath = $exportDirectory . '/' . $this->getFileName($this->export) . '.' . $this->getFileExtension();

    // Process the export
    $this->processExport($exportPath);

    // Mark export as completed
    $this->export->update([
      'completed_at' => now(),
      'processed_rows' => $this->export->total_rows,
      'successful_rows' => $this->export->total_rows,
    ]);
  }

  protected function processExport($exportPath)
  {
    // Check if template exists
    if (!file_exists($this->templatePath)) {
      throw new \Exception("Template file not found at: {$this->templatePath}");
    }

    try {
      // Create a temporary directory path for file operations
      $tempDir = sys_get_temp_dir();
      $tempFile = $tempDir . '/' . basename($this->templatePath);

      // Copy the template file to the temp location instead of loading it
      copy($this->templatePath, $tempFile);

      Log::info("Template copied to temp location: " . $tempFile);

      // Now load the copied file for modification
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tempFile);
      $worksheet = $spreadsheet->getActiveSheet();

      // Get SCP measurements
      $measurements = ScpMeasurement::query()
        ->with(['user', 'series', 'product', 'measurementFields'])
        ->get();

      // Define the column ranges for measurements
      $columnRanges = [
        'B' => ['start' => 21, 'end' => 45],
        'D' => ['start' => 21, 'end' => 45],
        'F' => ['start' => 21, 'end' => 45],
        'H' => ['start' => 21, 'end' => 45],
      ];

      // Insert basic info into the sheet
      if ($measurements->isNotEmpty()) {
        $firstMeasurement = $measurements->first();

        // Insert header information
        $worksheet->setCellValue('B10', $firstMeasurement->datetime->format('d.m.Y H:i'));
        $worksheet->setCellValue('B12', $firstMeasurement->user->name ?? '');
        $worksheet->setCellValue('B14', $firstMeasurement->series->series_number ?? '');
        $worksheet->setCellValue('B16', $firstMeasurement->product->name ?? '');
      }

      // Flatten all measurement values into a single array
      $allMeasurementValues = [];
      foreach ($measurements as $measurement) {
        foreach ($measurement->measurementFields as $field) {
          $allMeasurementValues[] = $field->measurement_value;
        }
      }

      // Place the values into the columns in sequence
      $valueIndex = 0;
      foreach ($columnRanges as $column => $range) {
        for ($row = $range['start']; $row <= $range['end']; $row++) {
          // If we've used all values, stop filling cells
          if ($valueIndex >= count($allMeasurementValues)) {
            break 2; // Break out of both loops
          }

          // Set the cell value - use setCellValueExplicit to ensure it's handled as a number
          $worksheet->setCellValueExplicit(
            "{$column}{$row}",
            $allMeasurementValues[$valueIndex],
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC
          );
          $valueIndex++;
        }
      }

      // Save the spreadsheet to the storage location
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

      // Important: Set these options to preserve charts and drawings
      $writer->setIncludeCharts(true);
      $writer->setPreCalculateFormulas(true);  // This will handle formula calculation

      // Save the file
      $writer->save(Storage::path($exportPath));

      // Clean up the temp file
      if (file_exists($tempFile)) {
        unlink($tempFile);
      }

      Log::info("Export completed and saved to: " . $exportPath);
    } catch (\Exception $e) {
      // Log the error and rethrow it
      Log::error('Template export error: ' . $e->getMessage());
      Log::error($e->getTraceAsString());
      throw $e;
    }
  }

  /**
   * Fix formula issues in the template
   */
  protected function fixFormulaIssues($spreadsheet)
  {
    // This method is no longer needed with the copy-based approach
    // We're leaving charts and formulas intact
  }
}
