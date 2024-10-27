<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

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
                        ->action(function () {
                            Log::info('reset password: ' . $this->record->email);
                            $user = $this->record;

                            // Memulai proses reset password dan mengirimkan email
                            $status = Password::sendResetLink(
                                ['email' => $user->email]
                            );

                            if ($status === Password::RESET_LINK_SENT) {
                                Notification::make()
                                    ->success()
                                    ->title('Link reset password telah dikirim')
                                    ->body('Link reset password telah dikirim ke email ' . $user->email)
                                    ->send();
                            } else {
                                Notification::make()
                                    ->error()
                                    ->title('Reset password gagal')
                                    ->body($status)
                                    ->send();
                            }
                        })
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
