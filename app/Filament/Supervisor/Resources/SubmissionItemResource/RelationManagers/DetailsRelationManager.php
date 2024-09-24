<?php

namespace App\Filament\Supervisor\Resources\SubmissionItemResource\RelationManagers;

use App\Models\Item;
use Filament\Actions\Action;
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
                Forms\Components\TextInput::make('qty_acc')
                    ->required()
                    ->numeric(),
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
                    ->label('Jumlah Request'),
                Tables\Columns\TextColumn::make('qty_acc')
                    ->label('Jumlah Di ACC'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    protected function canCreate(): bool
    {
        return false;
    }

    public function isReadOnly(): bool
    {
        return $this->getOwnerRecord()->status !== 'diajukan';
    }
}
