<?php

namespace App\Filament\Admin\Resources\OutgoingItemResource\Pages;

use App\Filament\Admin\Resources\OutgoingItemResource;
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

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
