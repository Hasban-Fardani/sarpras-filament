<?php

namespace App\Filament\Admin\Exports;

use App\Models\RequestItem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RequestItemExporter extends Exporter
{
    protected static ?string $model = RequestItem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('division.name')
                ->label('Divisi'),
            ExportColumn::make('operator.name')
                ->label('Operator'),
            ExportColumn::make('perihal')
                ->label('Perihal'),
            ExportColumn::make('sifat')
                ->label('Sifat'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('created_at')
                ->label('Dibuat'),
            ExportColumn::make('updated_at')
                ->label('Diubah'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your request item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
