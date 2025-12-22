<?php

namespace App\Http\Controllers;

use App\Filament\Exports\ScpMeasurementTemplateExporter;
use Exception;
use App\Jobs\ExportScpMeasurementsToTemplate;
use App\Models\ScpMeasurement;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ScpMeasurementExportController extends Controller
{
  public function exportToTemplate()
  {
    $templatePath = Storage::disk('local')->path('templates/scp-template2.xlsx');
    if (!file_exists($templatePath)) {
      Notification::make()
        ->danger()
        ->title('Template not found')
        ->body('Excel template not found. Please place your template at: ' . $templatePath)
        ->send();

      return redirect()->back();
    }

    $totalRows = ScpMeasurement::count();

    $export = Export::create([
      'user_id' => Auth::id(),
      'file_name' => 'scp-template-export-' . now()->format('Y-m-d-H-i-s'),
      'exporter' => 'App\\Filament\\Exports\\ScpMeasurementTemplateExporter',
      'file_disk' => 'local',
      'total_rows' => $totalRows,
    ]);

    ExportScpMeasurementsToTemplate::dispatch($export);

    Notification::make()
      ->success()
      ->title('Template Export started')
      ->body("Your export has begun and {$totalRows} rows will be processed in the background. You will receive a notification with the download link when it is complete.")
      ->send();

    return redirect()->back();
  }

  public function downloadLatestExport()
  {
    $latestExport = Export::where('user_id', Auth::id())
      ->where('exporter', 'App\\Filament\\Exports\\ScpMeasurementTemplateExporter')
      ->orderBy('created_at', 'desc')
      ->first();

    if (!$latestExport) {
      Notification::make()
        ->danger()
        ->title('No export found')
        ->body('No export was found for your account.')
        ->send();

      return redirect()->back();
    }

    $filePath = 'private/filament_exports/' . $latestExport->getKey() . '/' . $latestExport->file_name . '.xlsx';

    if (!Storage::disk('local')->exists($filePath)) {
      $filePath = 'private/private/filament_exports/' . $latestExport->getKey() . '/' . $latestExport->file_name . '.xlsx';
    }

    if (!Storage::disk('local')->exists($filePath)) {
      $exportDir = 'private/filament_exports/' . $latestExport->getKey();
      $altExportDir = 'private/private/filament_exports/' . $latestExport->getKey();

      $files = Storage::disk('local')->files($exportDir);
      if (empty($files)) {
        $files = Storage::disk('local')->files($altExportDir);
        if (!empty($files)) {
          $filePath = $files[0];
        }
      } else {
        $filePath = $files[0];
      }

      if (empty($files)) {
        Notification::make()
          ->danger()
          ->title('File not found')
          ->body('The export file could not be found. Please try exporting again.')
          ->send();

        return redirect()->back();
      }
    }

    $file = Storage::disk('local')->path($filePath);

    if (!file_exists($file)) {
      Notification::make()
        ->danger()
        ->title('File not found')
        ->body('The export file could not be found. Please try exporting again.')
        ->send();

      return redirect()->back();
    }

    while (ob_get_level()) {
      ob_end_clean();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $latestExport->file_name . '.xlsx"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    readfile($file);
    exit;
  }

  public function directDownload($id)
  {
    $export = Export::findOrFail($id);

    if ($export->user_id != Auth::id()) {
      abort(403, 'Unauthorized');
    }

    $paths = [
      'private/filament_exports/' . $export->getKey() . '/' . $export->file_name . '.xlsx',
      'private/private/filament_exports/' . $export->getKey() . '/' . $export->file_name . '.xlsx'
    ];

    $filePath = null;
    foreach ($paths as $path) {
      if (Storage::disk('local')->exists($path)) {
        $filePath = $path;
        break;
      }
    }

    if (!$filePath) {
      $directories = [
        'private/filament_exports/' . $export->getKey(),
        'private/private/filament_exports/' . $export->getKey()
      ];

      foreach ($directories as $dir) {
        $files = Storage::disk('local')->files($dir);
        if (!empty($files)) {
          $filePath = $files[0];
          break;
        }
      }
    }

    if (!$filePath) {
      abort(404, 'Export file not found');
    }

    $file = Storage::disk('local')->path($filePath);

    return response()->file($file, [
      'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'Content-Disposition' => 'attachment; filename="' . $export->file_name . '.xlsx"'
    ]);
  }

  public function directDownloadLatest()
  {
    $latestExport = Export::where('user_id', Auth::id())
      ->where('exporter', 'App\\Filament\\Exports\\ScpMeasurementTemplateExporter')
      ->where('file_name', 'like', 'scp-template-export-%')
      ->orderBy('created_at', 'desc')
      ->first();

    if (!$latestExport) {
      $latestExport = Export::where('user_id', Auth::id())
        ->where('exporter', 'App\\Filament\\Exports\\ScpMeasurementTemplateExporter')
        ->orderBy('created_at', 'desc')
        ->first();
    }

    if (!$latestExport) {
      abort(404, 'No export found');
    }

    $paths = [
      'private/filament_exports/' . $latestExport->getKey() . '/' . $latestExport->file_name . '.xlsx',
      'private/private/filament_exports/' . $latestExport->getKey() . '/' . $latestExport->file_name . '.xlsx'
    ];

    $filePath = null;
    foreach ($paths as $path) {
      if (Storage::disk('local')->exists($path)) {
        $filePath = $path;
        break;
      }
    }

    if (!$filePath) {
      $directories = [
        'private/filament_exports/' . $latestExport->getKey(),
        'private/private/filament_exports/' . $latestExport->getKey()
      ];

      foreach ($directories as $dir) {
        $files = Storage::disk('local')->files($dir);
        if (!empty($files)) {
          $filePath = $files[0];
          break;
        }
      }
    }

    if (!$filePath) {
      abort(404, 'Export file not found');
    }

    $file = Storage::disk('local')->path($filePath);

    return response()->file($file, [
      'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'Content-Disposition' => 'attachment; filename="' . $latestExport->file_name . '.xlsx"'
    ]);
  }

  public function freshExportAndDownload()
  {
    try {
      $templatePath = Storage::disk('local')->path('templates/scp-template2.xlsx');
      if (!file_exists($templatePath)) {
        Notification::make()
          ->danger()
          ->title('Template not found')
          ->body('Excel template not found. Please place your template at: ' . $templatePath)
          ->send();

        return redirect()->back();
      }

      Log::info('Starting fresh export and download with template: ' . $templatePath);

      $totalRows = ScpMeasurement::count();
      Log::info('Total records to export: ' . $totalRows);

      $export = Export::create([
        'user_id' => Auth::id(),
        'file_name' => 'scp-template-export-' . now()->format('Y-m-d-H-i-s'),
        'exporter' => 'App\\Filament\\Exports\\ScpMeasurementTemplateExporter',
        'file_disk' => 'local',
        'total_rows' => $totalRows,
      ]);

      Log::info('Created export record with ID: ' . $export->id);

      $exporter = new ScpMeasurementTemplateExporter($export);

      try {
        $exporter->handle();
        Log::info('Exporter handled successfully');
      } catch (Exception $e) {
        Log::error('Exception in exporter->handle(): ' . $e->getMessage());
        Log::error($e->getTraceAsString());

        Notification::make()
          ->danger()
          ->title('Export Error')
          ->body('Error processing the export: ' . $e->getMessage())
          ->send();

        return redirect()->back();
      }

      $paths = [
        'private/filament_exports/' . $export->getKey() . '/' . $export->file_name . '.xlsx',
        'private/private/filament_exports/' . $export->getKey() . '/' . $export->file_name . '.xlsx',
        'filament_exports/' . $export->getKey() . '/' . $export->file_name . '.xlsx'
      ];

      Log::info('Looking for export file in paths: ' . implode(', ', $paths));

      $filePath = null;
      foreach ($paths as $path) {
        if (Storage::disk('local')->exists($path)) {
          $filePath = $path;
          Log::info('Found file at path: ' . $path);
          break;
        }
      }

      if (!$filePath) {
        $directories = [
          'private/filament_exports/' . $export->getKey(),
          'private/private/filament_exports/' . $export->getKey(),
          'filament_exports/' . $export->getKey()
        ];

        foreach ($directories as $dir) {
          Log::info('Checking directory: ' . $dir);

          if (Storage::disk('local')->exists($dir)) {
            $files = Storage::disk('local')->files($dir);
            Log::info('Files in directory: ' . implode(', ', $files));

            if (!empty($files)) {
              $filePath = $files[0];
              Log::info('Using first file: ' . $filePath);
              break;
            }
          } else {
            Log::info('Directory does not exist: ' . $dir);
          }
        }
      }

      if (!$filePath) {
        Log::error('No export file found after checking all paths and directories');
        abort(404, 'Export file not found. The export process failed.');
      }

      $file = Storage::disk('local')->path($filePath);
      Log::info('Final file path for download: ' . $file);

      return response()->file($file, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Content-Disposition' => 'attachment; filename="' . $export->file_name . '.xlsx"'
      ]);
    } catch (Exception $e) {
      Log::error('Unhandled exception in freshExportAndDownload: ' . $e->getMessage());
      Log::error($e->getTraceAsString());

      abort(500, 'An unexpected error occurred: ' . $e->getMessage());
    }
  }
}
