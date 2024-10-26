<?php

namespace App\Filament\Admin\Resources\OutgoingItemResource\RelationManagers;

use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
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
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('item_id')
                    ->options(function (callable $get) {
                        $exists_items_id = $this->ownerRecord->load('details')->details->pluck('item_id');
                        return Item::whereNotIn('id', $exists_items_id)->get()->pluck('name', 'id');
                    })
                    ->reactive()
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('item.name'),
                Tables\Columns\TextColumn::make('qty'),
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

    protected function configureCreateAction(CreateAction $action): void
    {
        $action
            ->authorize(static fn(RelationManager $livewire): bool => (! $livewire->isReadOnly()) && $livewire->canCreate())
            ->form(fn(Form $form): Form => $this->form($form->columns(2)))
            ->after(function (array $data): void {
                Item::find($data['item_id'])->decrement('stock', $data['qty']);
            });
    }
}
