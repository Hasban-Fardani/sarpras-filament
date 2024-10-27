<?php

namespace App\Filament\Admin\Resources\SupplierResource\RelationManagers;

use App\Models\Employee;
use App\Models\IncomingItem;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IncomingItemsRelationManager extends RelationManager
{
    protected static ?string $label = 'Barang Masuk';
    protected static ?string $modelLabel = 'Barang Masuk';

    protected static string $relationship = 'incomingItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Petugas')
                    ->options(Employee::all()->pluck('name', 'id'))
                    ->default(Auth::id())
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(Supplier::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('note')
                    ->label('Catatan')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Petugas'),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier'),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Jumlah barang'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (IncomingItem $record): string => route('filament.admin.resources.incoming-items.view', $record)),
            ])
            ->bulkActions([
            ]);
    }
}
