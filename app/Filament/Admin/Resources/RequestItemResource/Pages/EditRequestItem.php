<?php

namespace App\Filament\Admin\Resources\RequestItemResource\Pages;

use App\Filament\Admin\Resources\RequestItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestItem extends EditRecord
{
    protected static string $resource = RequestItemResource::class;

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
