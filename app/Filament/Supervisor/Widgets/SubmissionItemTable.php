<?php

namespace App\Filament\Supervisor\Widgets;

use App\Models\SubmissionItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SubmissionItemTable extends BaseWidget
{
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SubmissionItem::with(['division'])->where('status', 'diajukan')
            )
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(function ($state) {
                        $colors = [
                            'draf' => 'secondary',
                            'diajukan' => 'warning',
                            'disetujui' => 'success',
                            'ditolak' => 'danger',
                        ];
                        return $colors[$state];
                    }),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Jumlah Item')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ]);
    }
}
