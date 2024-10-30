<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Exports\OutgoingItemExporter;
use App\Filament\Admin\Resources\OutgoingItemResource\Pages;
use App\Filament\Admin\Resources\OutgoingItemResource\RelationManagers;
use App\Models\OutgoingItem;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutgoingItemResource extends Resource
{
    protected static ?string $model = OutgoingItem::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-right-on-rectangle';

    protected static ?string $navigationLabel = 'Kelola Barang Keluar';

    protected static ?string $navigationGroup = 'Barang';

    protected static ?string $pluralModelLabel = 'Barang Keluar';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('operator_id')
                        ->label('Operator')
                        ->relationship('operator', 'name')
                        ->preload()
                        ->required(),
                    Select::make('division_id')
                        ->label('Nama Kepala Divisi')
                        ->relationship('division', 'name')
                        ->preload()
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
            ->headerActions([
                ExportAction::make()
                    ->exporter(OutgoingItemExporter::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutgoingItems::route('/'),
            'create' => Pages\CreateOutgoingItem::route('/create'),
            'edit' => Pages\EditOutgoingItem::route('/edit/{record}'),
            'view' => Pages\ViewOutgoingItem::route('/{record}'),
        ];
    }
}
