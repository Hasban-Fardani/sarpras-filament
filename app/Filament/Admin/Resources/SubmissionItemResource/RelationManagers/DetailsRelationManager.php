<?php

namespace App\Filament\Admin\Resources\SubmissionItemResource\RelationManagers;

use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

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
                        $items = Item::whereNotIn('id', $exists_items_id)->get()->pluck('name', 'id');
                        $current_item = Item::where('id', $get('item_id'))->first()->pluck('name', 'id');
                        $items->push($current_item);
                        return $items;
                    })
                    ->reactive()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->label('Qty')
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
                    ->label('Jumlah ACC'),
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
