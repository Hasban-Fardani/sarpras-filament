<?php

namespace App\Filament\Supervisor\Resources\SubmissionItemResource\Pages;

use App\Filament\Supervisor\Resources\SubmissionItemResource;
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
}
