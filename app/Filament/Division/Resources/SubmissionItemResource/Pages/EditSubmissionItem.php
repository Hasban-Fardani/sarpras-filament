<?php

namespace App\Filament\Division\Resources\SubmissionItemResource\Pages;

use App\Filament\Division\Resources\SubmissionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmissionItem extends EditRecord
{
    protected static string $resource = SubmissionItemResource::class;

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
