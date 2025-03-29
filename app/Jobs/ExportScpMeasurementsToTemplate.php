<?php

namespace App\Jobs;

use App\Filament\Exports\ScpMeasurementTemplateExporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportScpMeasurementsToTemplate implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $export;

  /**
   * Create a new job instance.
   */
  public function __construct(Export $export)
  {
    $this->export = $export;
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $exporter = new ScpMeasurementTemplateExporter($this->export);

    try {
      // Process the export
      $exporter->handle();

      // Send success notification
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
    } catch (\Exception $e) {
      // Update export as failed
      $this->export->update([
        'completed_at' => now(),
        'status' => 'failed',
      ]);

      // Send failure notification
      Notification::make()
        ->danger()
        ->title('Export failed')
        ->body('There was an error processing your export: ' . $e->getMessage())
        ->sendToDatabase($this->export->user);

      // Re-throw the exception for proper queue handling
      throw $e;
    }
  }
}
