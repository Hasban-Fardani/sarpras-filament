<?php

namespace App\Filament\Supervisor\Widgets;

use App\Models\RequestItem;
use App\Models\SubmissionItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionRequestItemChart extends ChartWidget
{
    protected static ?string $heading = 'Pengajuan Pengadaan & Permintaan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Query data Barang Masuk dan group by bulan
        $submission = SubmissionItem::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Query data Barang Keluar dan group by bulan
        $request_item = RequestItem::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Set labels bulan dalam format 'Jan', 'Feb', dst.
        $labels = collect(range(1, 12))->map(fn($month) => Carbon::createFromFormat('m', $month)->format('M'))->toArray();

        // Mapping data agar sesuai dengan urutan bulan di label
        $submissionData = array_map(fn($month) => $submission[$month] ?? 0, range(1, 12));
        $request_itemData = array_map(fn($month) => $request_item[$month] ?? 0, range(1, 12));

        // Data untuk chart
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pengadaan',
                    'data' => $submissionData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Permintaan',
                    'data' => $request_itemData,
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
