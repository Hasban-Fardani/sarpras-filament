<?php

namespace App\Filament\Supervisor\Resources\OutgoingItemResource\Pages;

use App\Filament\Supervisor\Resources\OutgoingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutgoingItem extends EditRecord
{
    protected static string $resource = OutgoingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
