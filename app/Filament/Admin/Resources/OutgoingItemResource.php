<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OutgoingItemResource\Pages;
use App\Filament\Admin\Resources\OutgoingItemResource\RelationManagers;
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
    protected static ?string $navigationLabel = 'Kelola Barang Keluar';

    protected static ?string $navigationGroup = 'Barang';
    protected static ?int $navigationSort = 5;


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
            'index' => Pages\ListOutgoingItems::route('/'),
            'create' => Pages\CreateOutgoingItem::route('/create'),
            'edit' => Pages\EditOutgoingItem::route('/{record}/edit'),
        ];
    }
}
