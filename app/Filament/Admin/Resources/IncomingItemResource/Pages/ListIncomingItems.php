<?php

namespace App\Filament\Admin\Resources\IncomingItemResource\Pages;

use App\Filament\Admin\Resources\IncomingItemResource;
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
