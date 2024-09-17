<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Profile')->schema([
                TextEntry::make('employee.name')
                    ->label('Nama'),
                TextEntry::make('username')
                    ->label('Username'),
                TextEntry::make('email')
                    ->label('Email'),
                TextEntry::make('nip')
                    ->label('NIP'),
                TextEntry::make('role')
                    ->label('Role'),
            ])
            ->columns(2)
            ->footerActions([
                Action::make('reset password')
                    ->modal()
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\EditAction::make(),
        ];
    }
}
