<?php

namespace App\Filament\Admin\Exports;

use App\Models\IncomingItem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class IncomingItemExporter extends Exporter
{
    protected static ?string $model = IncomingItem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee.name')
                ->label('Pengaju'),
            ExportColumn::make('supllier.name')
                ->label('Supplier'),
            ExportColumn::make('note')
                ->label('Keterangan'),
            ExportColumn::make('created_at')
                ->label('Dibuat'),
            ExportColumn::make('updated_at')
                ->label('Diubah'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your incoming item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}