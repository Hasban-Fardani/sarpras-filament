<?php

namespace App\Filament\Admin\Exports;

use App\Models\OutgoingItem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OutgoingItemExporter extends Exporter
{
    protected static ?string $model = OutgoingItem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('operator.name')
                ->label('Petugas Gudang'),
            ExportColumn::make('division.name')
                ->label('Divisi'),
            ExportColumn::make('note')
                ->label('Keterangan'),
            ExportColumn::make('is_taken')
                ->label('Diambil')
                ->format(fn ($value) => $value ? 'Ya' : 'Tidak'),
            ExportColumn::make('created_at')
                ->label('Dibuat'),
            ExportColumn::make('updated_at')
                ->label('Diubah'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your outgoing item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
