<?php

namespace App\Filament\Division\Resources\RequestItemResource\Pages;

use App\Filament\Division\Resources\RequestItemResource;
use App\Models\RequestItem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestItem extends EditRecord
{
    protected static string $resource = RequestItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(function (RequestItem $record) {
                    return $record->status !== 'diajukan';
                }),
        ];
    }
}
