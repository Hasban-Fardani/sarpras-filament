<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Item;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ItemMinimumStockTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 5;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Item::where('stock', '<', 'min_stock')
            )
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
            ]);
    }
}
