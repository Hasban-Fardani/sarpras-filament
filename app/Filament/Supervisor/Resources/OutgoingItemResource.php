<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\OutgoingItemResource\Pages;
use App\Filament\Supervisor\Resources\OutgoingItemResource\RelationManagers;
use App\Models\OutgoingItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutgoingItemResource extends Resource
{
    protected static ?string $model = OutgoingItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Barang Keluar';

    protected static ?string $pluralModelLabel = 'Barang Keluar';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('operator.name')
                    ->label('Petugas Gudang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->label('Catatan'),
                Tables\Columns\TextColumn::make('is_taken')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Sudah Diambil' : 'Belum Diambil')
                    ->color(fn($state) => $state ? 'success' : 'warning')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([]);
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
            'index' => Pages\ListOutgoingItems::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
