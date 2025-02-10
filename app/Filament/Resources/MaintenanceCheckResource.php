<?php

namespace App\Filament\Resources;

use App\Models\MaintenanceCheck;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\MaintenanceCheckResource\Pages;

class MaintenanceCheckResource extends Resource
{
  protected static ?string $model = MaintenanceCheck::class;
  protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';



  public static function form(Form $form): Form
  {
    return $form
      ->schema([])
      ->view('filament.resources.maintenance-check.form');
  }

  public static function table(Table $table): Table
  {
    $records = MaintenanceCheck::query()->paginate();
    return $table
      ->query(MaintenanceCheck::query())
      ->view('filament.resources.maintenance-check.table', compact('records'));
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListMaintenanceChecks::route('/'),
      'create' => Pages\CreateMaintenanceCheck::route('/create'),
      'edit' => Pages\EditMaintenanceCheck::route('/{record}/edit'),
    ];
  }
}
