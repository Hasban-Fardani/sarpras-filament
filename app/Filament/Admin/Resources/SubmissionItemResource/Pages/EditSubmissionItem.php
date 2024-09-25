<?php

namespace App\Filament\Admin\Resources\SubmissionItemResource\Pages;

use App\Filament\Admin\Resources\SubmissionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmissionItem extends EditRecord
{
    protected static string $resource = SubmissionItemResource::class;

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
