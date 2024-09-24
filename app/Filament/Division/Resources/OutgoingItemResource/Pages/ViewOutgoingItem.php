<?php

namespace App\Filament\Division\Resources\OutgoingItemResource\Pages;

use App\Filament\Division\Resources\OutgoingItemResource;
use App\Models\OutgoingItem;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOutgoingItem extends ViewRecord
{
    protected static string $resource = OutgoingItemResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi')->schema([ 
                    TextEntry::make('operator.name')
                ]),
            ]);
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('take')
                ->label('Sudah Diambil')
                ->button()
                ->modal()
                ->modalHeading('Konfirmasi Ubah Status')
                ->modalDescription('Apakah Anda yakin ingin mengubah status?')
                ->action(function (OutgoingItem $record) {
                    $record->update(['is_taken' => true]);
                })
                ->hidden(fn(OutgoingItem $record) => $record->is_taken),
        ];
    }
}
