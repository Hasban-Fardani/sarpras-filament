<?php

namespace App\Filament\Supervisor\Resources\RequestItemResource\Pages;

use App\Filament\Supervisor\Resources\RequestItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestItems extends ListRecords
{
    protected static string $resource = RequestItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
