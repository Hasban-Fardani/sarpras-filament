<?php

namespace App\Filament\Supervisor\Resources\IncomingItemResource\Pages;

use App\Filament\Supervisor\Resources\IncomingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomingItems extends ListRecords
{
    protected static string $resource = IncomingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
