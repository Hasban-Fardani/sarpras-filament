<?php

namespace App\Filament\Division\Widgets;

use App\Models\Item;
use App\Models\RequestItemDetail;
use App\Models\SubmissionItemDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $items_count = Item::count();
        $request_item_counts = RequestItemDetail::with('requestItem')
            ->whereHas('requestItem', function ($query) {
                $query->where('division_id', Auth::user()->employee->id);
            })
            ->sum('qty');
        $submission_item_counts = SubmissionItemDetail::with('submissionItem')
            ->whereHas('submissionItem', function ($query) {
                $query->where('division_id', Auth::user()->employee->id);
            })
            ->sum('qty');

        return [
            Stat::make('Barang', $items_count),
            Stat::make('Pengajuan Permintaan', $request_item_counts),
            Stat::make('Pengajuan Pengadaan', $submission_item_counts),
        ];
    }
}
