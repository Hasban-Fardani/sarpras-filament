<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Exports\ItemExporter;
use App\Filament\Admin\Resources\ItemResource\Pages;
use App\Filament\Admin\Resources\ItemResource\RelationManagers;
use App\Models\Category;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->columnSpan(2),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->required()
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('merk')
                        ->label('Merk')
                        ->required()
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('type')
                        ->label('Tipe')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga per satuan')
                        ->required()
                        ->numeric()
                        ->prefix('Rp. ')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('stock')
                        ->label('Stok')
                        ->required()
                        ->numeric()
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('min_stock')
                        ->label('Min. Stok')
                        ->required()
                        ->numeric()
                        ->columnSpan(3),
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->image()
                        ->required()
                        ->disk('items_image')
                        ->columnSpanFull(),
                ])->columns(6)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->label('Gambar')
                        ->disk('items_image'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->label('Nama')
                            ->searchable(),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('price')
                            ->label('Harga/satuan')
                            ->money(currency: 'IDR', locale: 'id')
                            ->sortable()
                            ->suffix(' /'),
                        Tables\Columns\TextColumn::make('unit')
                            ->label('Satuan')
                            ->searchable(),
                    ]),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->sortable()
                            ->prefix('stok: '),
                        Tables\Columns\TextColumn::make('min_stock')
                            ->label('Min. Stok')
                            ->numeric()
                            ->sortable()
                            ->prefix('min. stok: '),
                    ]),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->exporter(ItemExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-document'),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
