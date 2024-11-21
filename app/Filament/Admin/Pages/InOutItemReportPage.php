<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class InOutItemReportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Barang Masuk Keluar';

    protected static ?string $navigationGroup = 'Laporan';

    protected static string $view = 'filament.admin.pages.in-out-item-report-page';
}
