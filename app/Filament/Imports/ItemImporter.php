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
            ImportColumn::make('nama')
                ->label('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kategori')
                ->label('kategori')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('satuan')
                ->label('satuan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('merk')
                ->label('merk')
                ->rules(['max:255']),
            ImportColumn::make('jenis')
                ->label('tipe')
                ->rules(['max:255']),
            ImportColumn::make('ukuran')
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
            ImportColumn::make('harga')
                ->label('harga')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Item
    {
        $category = Category::where('name', $this->data['kategori'])->first();
        if (!$category) {
            $category = Category::create([
                'name' => $this->data['category'],
            ]);
        }
        return Item::create([
            'name' => $this->data['nama'],
            'unit' => $this->data['unit'],
            'merk' => $this->data['merek'],
            'type' => $this->data['jenis'],
            'size' => $this->data['ukuran'],
            'stock' => $this->data['stock'],
            'min_stock' => $this->data['min_stock'],
            'price' => $this->data['harga'],
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
