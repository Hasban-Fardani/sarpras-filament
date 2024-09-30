<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\IncomingItemResource\Pages;
use App\Filament\Supervisor\Resources\IncomingItemResource\RelationManagers;
use App\Models\IncomingItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomingItemResource extends Resource
{
    protected static ?string $model = IncomingItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Barang Masuk';

    protected static ?string $pluralModelLabel = 'Barang Masuk';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Petugas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_items')
                    ->label('Jumlah Item')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListIncomingItems::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
