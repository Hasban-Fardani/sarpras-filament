<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;

class InOutItemChart extends ChartWidget
{
    protected static ?string $heading = 'Pengadaan / Permintaan';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
