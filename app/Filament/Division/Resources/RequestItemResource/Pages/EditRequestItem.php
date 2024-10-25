<?php

namespace App\Filament\Division\Resources\RequestItemResource\Pages;

use App\Filament\Division\Resources\RequestItemResource;
use App\Models\RequestItem;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

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

    protected function getFormActions(): array
    {
        return [
            $this->getSubmitAction(),
            $this->getCancelFormAction()->label('Kembali'),
        ];
    }

    protected function getSubmitAction()
    {
        $action = Action::make('submit')
            ->label('Ajukan')
            ->action(function () {
                $this->record->update([
                    'status' => 'diajukan'
                ]);
            });
            
        if ($this->record->status === 'diajukan') {
            $action = Action::make('submit')
                ->label('Draf')
                ->color(Color::Slate)
                ->action(function () {
                    $this->record->update([
                        'status' => 'draf'
                    ]);
                });
        }

        return $action;
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
