<?php

namespace App\Filament\Supervisor\Resources\SubmissionItemResource\Pages;

use App\Filament\Supervisor\Resources\SubmissionItemResource;
use App\Models\SubmissionItem;
use Filament\Infolists\Components\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;

class ViewSubmissionItem extends ViewRecord
{
    protected static string $resource = SubmissionItemResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('informasi')->schema([
                TextEntry::make('division.name')
                    ->size(TextEntrySize::Large)
                    ->weight(FontWeight::Bold)
                    ->label('Pengaju'),
                TextEntry::make('created_at')
                    ->label('Dibuat'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
            ])
                ->columns(2)
                ->footerActions([
                    Action::make('setujui')
                        ->color(Color::Blue)
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Permintaan')
                        ->modalDescription('Permintaan Akan disetujui, apakah anda yakin?')
                        ->modalSubmitActionLabel('Kirim')
                        ->modalCancelActionLabel('Batal')
                        ->modalSubmitAction(fn(StaticAction $action) => $action->color(Color::Blue))
                        ->action(function (SubmissionItem $record) {
                            // check if submission detail item qty is 0
                            if ($record->total_items_acc == 0) {
                                Notification::make()
                                    ->title('Permintaan Gagal')
                                    ->warning()
                                    ->body('Permintaan tidak dapat diterima, karena total item acc = 0')
                                    ->send()
                                    ->toDatabase();
                                return;
                            }


                            $record->update(['status' => 'disetujui']);

                            Notification::make()
                                ->title('Berhasil merubah status Permintaan')
                                ->success()
                                ->send()
                                ->toDatabase();

                            $division_user = $record->division->user;
                            $division_user->notify(
                                Notification::make('Pengadaan Disetujui')
                                    ->title('Pengadaan: ' . $record->id . 'Disetujui')
                                    ->success()
                                    ->toDatabase()
                            );

                            return redirect()->route('filament.supervisor.resources.submission-items.index');
                        })
                        ->visible(fn($livewire): bool => $livewire instanceof ViewRecord)
                        ->hidden(fn(SubmissionItem $record): bool => $record->status !== 'diajukan'),
                    Action::make('tolak')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Permintaan')
                        ->modalDescription('Permintaan Akan disetujui, apakah anda yakin?')
                        ->modalSubmitActionLabel('Kirim')
                        ->modalCancelActionLabel('Batal')
                        ->modalSubmitAction(fn(StaticAction $action) => $action->color(Color::Blue))
                        ->form([
                            Textarea::make('alasan_ditolak')
                                ->label('Alasan Ditolak')
                                ->required()
                                ->placeholder('Masukkan alasan mengapa permintaan ditolak')
                        ])
                        ->action(function (SubmissionItem $record, array $data) {
                            Notification::make()
                                ->title('Berhasil merubah status Permintaan')
                                ->success()
                                ->send()
                                ->toDatabase();

                            $record->update(['status' => 'ditolak']);
                            $division_user = $record->division->user;
                            $division_user->notify(
                                Notification::make('Permintaan Ditolak')
                                    ->title('Permintaan: ' . $record->id . ' Ditolak')
                                    ->body("Alasan ditolak: " . $data['alasan_ditolak'])
                                    ->danger()
                                    ->toDatabase()
                            );

                            return redirect()->route('filament.supervisor.resources.submission-items.index');
                        })
                        ->visible(fn($livewire): bool => $livewire instanceof ViewRecord)
                        ->hidden(fn(SubmissionItem $record): bool => $record->status !== 'diajukan'),
                ])->footerActionsAlignment(Alignment::Center),
        ]);
    }
}
