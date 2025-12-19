<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;
use Filament\Facades\Filament;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function getPluralModelLabel(): string
    {
        return __('messages.users');
    }

    public static function getModelLabel(): string
    {
        return __('messages.user_accusative');
    }
    protected static string | \UnitEnum | null $navigationGroup = 'Kadri';

    public static function getNavigationLabel(): string
    {
        return trans('messages.users');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Select::make('role')
                    ->options(function () {
                        /** @var User $currentUser */
                        $currentUser = Filament::auth()->user();

                        $roles = [
                            'user' => 'Uporabnik',
                            'admin' => 'Administrator'
                        ];

                        if ($currentUser && !$currentUser->hasRole('admin')) {
                            unset($roles['admin']);
                        }

                        return $roles;
                    })
                    ->default('user')
                    ->required()
                    ->label('Role')
                    ->dehydrated(false)
                    ->native(false)
                    ->afterStateHydrated(function (Select $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentRole = $record->roles->first()?->name ?? 'user';
                            $component->state($currentRole);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label(trans('messages.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(function ($record) {
                        return $record->roles->first()?->name ?? 'No Role';
                    })
                    ->color(function ($record) {
                        $role = $record->roles->first()?->name;
                        return match ($role) {
                            'admin' => 'success',
                            'user' => 'warning',
                            default => 'gray'
                        };
                    }),

                TextColumn::make('created_at')
                    ->label(trans('messages.created_at'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label(trans('messages.edit')),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
