<?php

namespace App\Filament\Exports;

use Exception;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
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
    $this->templatePath = Storage::disk('local')->path('templates/scp-template2.xlsx');
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
    if (strpos($export->file_name, 'scp-template-export-') === 0) {
      return $export->file_name;
    }

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
    $exportDirectory = $this->getFileDirectory();
    if (!Storage::exists($exportDirectory)) {
      Storage::makeDirectory($exportDirectory);
    }

    $exportPath = $exportDirectory . '/' . $this->getFileName($this->export) . '.' . $this->getFileExtension();
    $this->processExport($exportPath);

    $this->export->update([
      'completed_at' => now(),
      'processed_rows' => $this->export->total_rows,
      'successful_rows' => $this->export->total_rows,
    ]);
  }

  protected function processExport($exportPath)
  {
    if (!file_exists($this->templatePath)) {
      throw new Exception("Template file not found at: {$this->templatePath}");
    }

    try {
      $tempDir = sys_get_temp_dir();
      $tempFile = $tempDir . '/' . basename($this->templatePath);

      copy($this->templatePath, $tempFile);

      Log::info("Template copied to temp location: " . $tempFile);

      $spreadsheet = IOFactory::load($tempFile);
      $worksheet = $spreadsheet->getActiveSheet();

      $measurements = ScpMeasurement::query()
        ->with(['user', 'series', 'product', 'measurementFields'])
        ->get();

      $columnRanges = [
        'B' => ['start' => 21, 'end' => 45],
        'D' => ['start' => 21, 'end' => 45],
        'F' => ['start' => 21, 'end' => 45],
        'H' => ['start' => 21, 'end' => 45],
      ];

      if ($measurements->isNotEmpty()) {
        $firstMeasurement = $measurements->first();

        $worksheet->setCellValue('B10', $firstMeasurement->datetime->format('d.m.Y H:i'));
        $worksheet->setCellValue('B12', $firstMeasurement->user->name ?? '');
        $worksheet->setCellValue('B14', $firstMeasurement->series->series_number ?? '');
        $worksheet->setCellValue('B16', $firstMeasurement->product->name ?? '');
      }

      $allMeasurementValues = [];
      foreach ($measurements as $measurement) {
        foreach ($measurement->measurementFields as $field) {
          $allMeasurementValues[] = $field->measurement_value;
        }
      }

      $valueIndex = 0;
      foreach ($columnRanges as $column => $range) {
        for ($row = $range['start']; $row <= $range['end']; $row++) {
          if ($valueIndex >= count($allMeasurementValues)) {
            break 2; 
          }

          $worksheet->setCellValueExplicit(
            "{$column}{$row}",
            $allMeasurementValues[$valueIndex],
            DataType::TYPE_NUMERIC
          );
          $valueIndex++;
        }
      }


      $writer = new Xlsx($spreadsheet);
      $writer->setIncludeCharts(true);
      $writer->setPreCalculateFormulas(true); 
      $writer->save(Storage::path($exportPath));


      if (file_exists($tempFile)) {
        unlink($tempFile);
      }

      Log::info("Export completed and saved to: " . $exportPath);
    } catch (Exception $e) {
      Log::error('Template export error: ' . $e->getMessage());
      Log::error($e->getTraceAsString());
      throw $e;
    }
  }

  
  protected function fixFormulaIssues($spreadsheet)
  {
   
  }
}
