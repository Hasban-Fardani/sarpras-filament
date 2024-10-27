<?php

namespace App\Filament\Supervisor\Widgets;

use App\Models\IncomingItem;
use App\Models\OutgoingItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InOutItemChart extends ChartWidget
{
    protected static ?string $heading = 'Barang Masuk/Keluar';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Query data Barang Masuk dan group by bulan
        $barangMasuk = IncomingItem::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Query data Barang Keluar dan group by bulan
        $barangKeluar = OutgoingItem::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Set labels bulan dalam format 'Jan', 'Feb', dst.
        $labels = collect(range(1, 12))->map(fn($month) => Carbon::createFromFormat('m', $month)->format('M'))->toArray();

        // Mapping data agar sesuai dengan urutan bulan di label
        $barangMasukData = array_map(fn($month) => $barangMasuk[$month] ?? 0, range(1, 12));
        $barangKeluarData = array_map(fn($month) => $barangKeluar[$month] ?? 0, range(1, 12));

        // Data untuk chart
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $barangMasukData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Barang Keluar',
                    'data' => $barangKeluarData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        return $chartData;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
