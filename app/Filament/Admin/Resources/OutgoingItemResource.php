<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OutgoingItemResource\Pages;
use App\Filament\Admin\Resources\OutgoingItemResource\RelationManagers;
use App\Models\OutgoingItem;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

    protected static ?string $pluralModelLabel = 'Barang Keluar';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('operator_id')
                        ->required()
                        ->numeric(),
                    TextInput::make('division_id')
                        ->required()
                        ->numeric(),
                    TextInput::make('qty')
                        ->required()
                        ->numeric()
                        ->default(0),
                    Textarea::make('note')
                        ->columnSpanFull(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('operator.name')
                    ->label('Operator')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Nama Kepala Divisi')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutgoingItems::route('/'),
            'create' => Pages\CreateOutgoingItem::route('/create'),
        ];
    }
}
