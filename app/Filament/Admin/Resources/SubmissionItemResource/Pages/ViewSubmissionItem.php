<?php

namespace App\Filament\Admin\Resources\SubmissionItemResource\Pages;

use App\Filament\Admin\Resources\SubmissionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSubmissionItem extends ViewRecord
{
    protected static string $resource = SubmissionItemResource::class;
    
    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
