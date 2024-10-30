<?php

namespace App\Filament\Supervisor\Widgets;

use App\Models\RequestItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RequestItemTable extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RequestItem::with(['division'])->where('status', 'diajukan')
            )
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
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
                    ->label('Total Item')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ]);
    }
}
