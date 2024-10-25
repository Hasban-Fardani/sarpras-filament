<?php

namespace App\Filament\Division\Widgets;

use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\OutgoingItemDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $items_count = Item::count();
        $incoming_items_count = IncomingItemDetail::sum('qty');
        $outgoing_items_count = OutgoingItemDetail::sum('qty');

        return [
            Stat::make('Barang', $items_count),
            Stat::make('Barang Masuk', $incoming_items_count),
            Stat::make('Barang Keluar', $outgoing_items_count),
        ];
    }
}
