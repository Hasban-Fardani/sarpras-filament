<?php

namespace App\Filament\Admin\Resources\IncomingItemResource\Pages;

use App\Filament\Admin\Resources\IncomingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncomingItem extends ViewRecord
{
    protected static string $resource = IncomingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
