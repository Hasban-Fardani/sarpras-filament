<?php

namespace App\Filament\Admin\Resources\SubmissionItemResource\Pages;

use App\Filament\Admin\Resources\SubmissionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubmissionItems extends ListRecords
{
    protected static string $resource = SubmissionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
