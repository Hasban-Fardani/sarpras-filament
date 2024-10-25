<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class ItemBalanceReportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.item-balance-report-page';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Saldo Barang';
}
