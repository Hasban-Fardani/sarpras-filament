<?php

namespace App\Filament\Division\Resources\SubmissionItemResource\Pages;

use App\Filament\Division\Resources\SubmissionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubmissionItem extends CreateRecord
{
    protected static string $resource = SubmissionItemResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
