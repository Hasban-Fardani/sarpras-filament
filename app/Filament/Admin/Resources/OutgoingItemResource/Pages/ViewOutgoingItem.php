<?php

namespace App\Filament\Admin\Resources\OutgoingItemResource\Pages;

use App\Filament\Admin\Resources\OutgoingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOutgoingItem extends ViewRecord
{
    protected static string $resource = OutgoingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
