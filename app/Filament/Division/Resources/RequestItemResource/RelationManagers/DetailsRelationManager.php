<?php

namespace App\Filament\Division\Resources\RequestItemResource\RelationManagers;

use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->label('Barang')
                    ->options(function (callable $get) {
                        $exists_items_id = $this->ownerRecord->load('details')->details->pluck('item_id'); 
                        return Item::whereNotIn('id', $exists_items_id)->get()->pluck('name', 'id');
                    })
                    ->reactive()
                    ->searchable()
                    ->searchable(),
                Forms\Components\TextInput::make('qty')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Barang'),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('qty_acc')
                    ->label('Jumlah Disetujui'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
