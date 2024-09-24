<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\RequestItemResource\Pages;
use App\Filament\Supervisor\Resources\RequestItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\RequestItem;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RequestItemResource extends Resource
{
    protected static ?string $model = RequestItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Permintaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi')->schema([
                    Forms\Components\Select::make('employee_id')
                        ->label('Pengaju')
                        ->required()
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->default(Auth::id())
                        ->disabled(),
                    Forms\Components\TextInput::make('status')
                        ->disabled(),
                ])
                ->footerActions([
                    Action::make('setujui')
                        ->color(Color::Blue),
                    Action::make('tolak')
                        ->color('danger'),
                ])
                ->footerActionsAlignment(Alignment::Center),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(RequestItem::where('status', '<>', 'draf'))
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Pengaju')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function ($state) {
                        $colors = [
                            'draf' => 'secondary',
                            'diajukan' => 'warning',
                            'disetujui' => 'success',
                            'ditolak' => 'danger',
                        ];
                        return $colors[$state];
                    }),
                Tables\Columns\TextColumn::make('total_items')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequestItems::route('/'),
            'edit' => Pages\EditRequestItem::route('/{record}/edit'),
        ];
    }
}
