<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\IncomingItemResource\Pages;
use App\Filament\Admin\Resources\IncomingItemResource\RelationManagers;
use App\Models\IncomingItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomingItemResource extends Resource
{
    protected static ?string $model = IncomingItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Barang';

    protected static ?string $navigationLabel = 'Kelola Barang Masuk';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListIncomingItems::route('/'),
            'create' => Pages\CreateIncomingItem::route('/create'),
            'edit' => Pages\EditIncomingItem::route('/{record}/edit'),
        ];
    }
}
