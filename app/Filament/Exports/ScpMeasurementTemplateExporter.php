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
    $this->templatePath = storage_path('app/templates/scp_measurements_template.xlsx');
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
    return $export->file_name;
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
      // Load the template using fully qualified class name
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->templatePath);
      $worksheet = $spreadsheet->getActiveSheet();

      // Get SCP measurements
      $measurements = ScpMeasurement::query()
        ->with(['user', 'series', 'product', 'measurementFields'])
        ->get();

      // Starting row in the template where data should be inserted
      $startRow = 10; // Adjust this based on your template

      // Loop through measurements and insert into specific cells
      foreach ($measurements as $index => $measurement) {
        $row = $startRow + $index;

        // Insert data into specific cells - adjust cell references based on your template
        $worksheet->setCellValue("A{$row}", $measurement->datetime->format('d.m.Y H:i'));
        $worksheet->setCellValue("B{$row}", $measurement->user->name ?? '');
        $worksheet->setCellValue("C{$row}", $measurement->series->series_number ?? '');
        $worksheet->setCellValue("D{$row}", $measurement->product->name ?? '');

        // For measurement fields, you might need a specific approach based on your template
        $measurementText = $measurement->measurementFields->map(function ($field) {
          return sprintf(
            'Part %d: Nest %d = %s',
            $field->field_number,
            $field->nest_number,
            $field->measurement_value
          );
        })->join(", ");

        $worksheet->setCellValue("E{$row}", $measurementText);
      }

      // Save the spreadsheet to the storage using fully qualified class name
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save(Storage::path($exportPath));
    } catch (\Exception $e) {
      // Log the error and rethrow it
      Log::error('Template export error: ' . $e->getMessage());
      throw $e;
    }
  }
}
