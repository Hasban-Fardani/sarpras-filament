<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Exports\ItemExporter;
use App\Filament\Admin\Resources\ItemResource\Pages;
use App\Filament\Admin\Resources\ItemResource\RelationManagers;
use App\Filament\Imports\ItemImporter;
use App\Models\Category;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-m-archive-box';
    protected static ?string $navigationGroup = 'Barang';
    protected static ?string $navigationLabel = 'Kelola Data Barang';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->image()
                        ->disk('items_image')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('merk')
                        ->label('Merk')
                        ->maxLength(255)
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('type')
                        ->label('Tipe')
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('size')
                        ->label('Ukuran')
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('stock')
                        ->label('Stok')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('min_stock')
                        ->label('Stok Minimum')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->prefix('Rp. ')
                        ->columnSpan(3),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->required()
                        ->columnSpan(3),
                ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('items_image'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merk')
                    ->label('Merk'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe'),
                Tables\Columns\TextColumn::make('size')
                    ->label('Ukuran'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Min.Stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', 0, 'id_ID')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->multiple()
                    ->relationship('category', 'name')
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->headerActions([
                ImportAction::make()
                    ->importer(ItemImporter::class)
                    ->label('Import Data')
                    ->icon('heroicon-o-folder-plus'),
                ExportAction::make()
                    ->exporter(ItemExporter::class)
                    ->label('Export Data'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
