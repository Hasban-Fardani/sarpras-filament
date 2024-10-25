<?php

namespace App\Filament\Imports;

use App\Models\Category;
use App\Models\Item;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('unit')
                ->label('satuan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('merk')
                ->label('merk')
                ->rules(['max:255']),
            ImportColumn::make('type')
                ->label('tipe')
                ->rules(['max:255']),
            ImportColumn::make('size')
                ->label('ukuran')
                ->rules(['max:255']),
            ImportColumn::make('stock')
                ->label('stok')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('min_stock')
                ->label('min_stok')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('price')
                ->label('harga')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Item
    {
        $category = Category::where('name', $this->data['category'])->first();
        if (!$category) {
            $category = Category::create([
                'name' => $this->data['category'],
            ]);
        }
        return Item::create([
            'name' => $this->data['name'],
            'unit' => $this->data['unit'],
            'merk' => $this->data['merk'],
            'type' => $this->data['type'],
            'size' => $this->data['size'],
            'stock' => $this->data['stock'],
            'min_stock' => $this->data['min_stock'],
            'price' => $this->data['price'],
            'category_id' => $category->id,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
