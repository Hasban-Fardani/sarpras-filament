<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\IncomingItemResource\Pages;
use App\Filament\Admin\Resources\IncomingItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\IncomingItem;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IncomingItemResource extends Resource
{
    protected static ?string $model = IncomingItem::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-down-on-square-stack';
    
    protected static ?string $navigationGroup = 'Barang';

    protected static ?string $navigationLabel = 'Kelola Barang Masuk';

    protected static ?string $pluralModelLabel = 'Barang Masuk';

    protected static ?string $recordTitleAttribute = 'employee.name';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('employee_id')
                        ->label('Petugas')
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->default(Auth::user()->employee->id)
                        ->required(),
                    Select::make('supplier_id')
                        ->label('Supplier')
                        ->options(Supplier::all()->pluck('name', 'id'))
                        ->required(),
                    Textarea::make('note')
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Petugas')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_items')
                    ->label('Jumlah Barang')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomingItems::route('/'),
            'create' => Pages\CreateIncomingItem::route('/create'),
            'view' => Pages\ViewIncomingItem::route('/{record}'),
            'edit' => Pages\EditIncomingItem::route('/{record}/edit'),
        ];
    }
}
