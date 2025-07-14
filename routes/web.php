<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ScpMeasurementExportController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin');
    }

    return redirect('/admin/login');
});
Route::resource('machines', MachineController::class);

// SCP Measurement template export route
Route::get('/scp-measurements/export-to-template', [ScpMeasurementExportController::class, 'exportToTemplate'])
    ->name('scp-measurements.export-to-template')
    ->middleware(['auth']);

// Download latest SCP Measurement export
Route::get('/scp-measurements/download-latest-export', [ScpMeasurementExportController::class, 'downloadLatestExport'])
    ->name('scp-measurements.download-latest-export')
    ->middleware(['auth']);

// Direct download route with ID parameter
Route::get('/scp-measurements/direct-download/{id}', [ScpMeasurementExportController::class, 'directDownload'])
    ->name('scp-measurements.direct-download')
    ->middleware(['auth']);

// Direct download latest route (no parameters needed)
Route::get('/scp-measurements/direct-download-latest', [ScpMeasurementExportController::class, 'directDownloadLatest'])
    ->name('scp-measurements.direct-download-latest')
    ->middleware(['auth']);

// Fresh export and immediate download (creates and downloads in one step)
Route::get('/scp-measurements/fresh-export-download', [ScpMeasurementExportController::class, 'freshExportAndDownload'])
    ->name('scp-measurements.fresh-export-download')
    ->middleware(['auth']);
