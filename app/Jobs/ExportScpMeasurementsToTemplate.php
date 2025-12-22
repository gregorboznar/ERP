<?php

namespace App\Jobs;

use Filament\Actions\Action;
use Exception;
use App\Filament\Exports\ScpMeasurementTemplateExporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportScpMeasurementsToTemplate implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $export;

  public function __construct(Export $export)
  {
    $this->export = $export;
  }

  
  public function handle(): void
  {
    $exporter = new ScpMeasurementTemplateExporter($this->export);

    try {
      $exporter->handle();

      Notification::make()
        ->success()
        ->title('Export completed')
        ->body('Your export has been completed successfully.')
        ->actions([
          Action::make('download')
            ->label('Download')
            ->url(fn() => $this->export->getDownloadUrl())
            ->openUrlInNewTab(),
        ])
        ->sendToDatabase($this->export->user);
    } catch (Exception $e) {
      $this->export->update([
        'completed_at' => now(),
        'status' => 'failed',
      ]);

      Notification::make()
        ->danger()
        ->title('Export failed')
        ->body('There was an error processing your export: ' . $e->getMessage())
        ->sendToDatabase($this->export->user);

      throw $e;
    }
  }
}
