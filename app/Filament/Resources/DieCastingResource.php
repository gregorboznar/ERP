<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DieCastingResource\Pages;
use App\Filament\Resources\DieCastingResource\RelationManagers;
use App\Models\DieCasting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DieCastingResource extends Resource
{
    protected static ?string $model = DieCasting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\DatePicker::make('date')
                                ->label(__('messages.date'))
                                ->native(false)
                                ->required()
                                ->default(now()->format('Y-m-d')),
                            Forms\Components\TimePicker::make('start_time')
                                ->label(__('messages.start_time'))
                                ->format('H:i')
                                ->withoutSeconds()
                                ->default(now()->format('H:i'))
                                ->required(),
                            Forms\Components\TextInput::make('counter_start')
                                ->label(__('messages.counter_start'))
                                ->required()
                                ->numeric(),
                            Forms\Components\TimePicker::make('end_time')
                                ->label(__('messages.end_time'))
                                ->format('H:i')
                                ->withoutSeconds(),
                            Forms\Components\TextInput::make('counter_end')
                                ->label(__('messages.counter_end'))
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('good_parts_count')
                                ->label(__('messages.good_parts_count'))
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('technological_waste')
                                ->label(__('messages.technological_waste'))
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('batch_of_material')
                                ->label(__('messages.batch_of_material')),
                            Forms\Components\TextInput::make('palet_number')
                                ->label(__('messages.palet_number')),
                            Forms\Components\TextInput::make('waste_slag_weight')
                                ->label(__('messages.waste_slag_weight'))

                                ->numeric(),
                        ])
                        ->columns(2)
                        ->columnSpan(['lg' => 2]),


                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Textarea::make('stopage_reason')
                                ->label(__('messages.stopage_reason'))
                                ->rows(6),
                            Forms\Components\Textarea::make('notes')
                                ->label(__('messages.notes'))
                                ->rows(6),
                        ])
                        ->columns(1)
                        ->columnSpan(['lg' => 1]),
                ])->columns(3),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDieCastings::route('/'),

            'edit' => Pages\EditDieCasting::route('/{record}/edit'),
        ];
    }
}
