<?php

namespace App\Filament\Division\Resources\SubmissionItemResource\Pages;

use App\Filament\Division\Resources\SubmissionItemResource;
use App\Models\SubmissionItem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmissionItem extends EditRecord
{
    protected static string $resource = SubmissionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(function (SubmissionItem $record) {
                    return $record->status !== 'diajukan';
                }),
        ];
    }
}