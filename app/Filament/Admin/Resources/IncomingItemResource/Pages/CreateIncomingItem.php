<?php

namespace App\Filament\Admin\Resources\IncomingItemResource\Pages;

use App\Filament\Admin\Resources\IncomingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomingItem extends CreateRecord
{
    protected static string $resource = IncomingItemResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view');
    }
}
