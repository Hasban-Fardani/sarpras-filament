<?php

namespace App\Filament\Admin\Resources\RequestItemResource\Pages;

use App\Filament\Admin\Resources\RequestItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestItem extends CreateRecord
{
    protected static string $resource = RequestItemResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
