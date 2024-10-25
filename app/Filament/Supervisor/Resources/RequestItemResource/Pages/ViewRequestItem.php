<?php

namespace App\Filament\Supervisor\Resources\RequestItemResource\Pages;

use App\Filament\Supervisor\Resources\RequestItemResource;
use App\Models\OutgoingItem;
use App\Models\RequestItem;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class ViewRequestItem extends ViewRecord
{
    protected static string $resource = RequestItemResource::class;

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
                        ->action(function (RequestItem $record) {
                            $record->update(['status' => 'disetujui']);

                            $division_employee = $record->employee;

                            $items = [];
                            
                            $outgoingItem = OutgoingItem::create([
                                'operator_id' => Auth::user()->employee->id,
                                'division_id' => $division_employee->id 
                            ]);

                            $record->details->each(function ($detail) use (&$items, $outgoingItem) {
                                array_push($items, [
                                    'outgoing_item_id' => $outgoingItem->id,
                                    'item_id' => $detail->item_id,
                                    'qty' => $detail->qty_acc,
                                    'created_at' => now()
                                ]);
                            });
                            
                            $outgoingItem->details()->insert($items);

                            Notification::make()
                                ->title('Berhasil merubah status Permintaan')
                                ->success()
                                ->send()
                                ->toDatabase();

                            $division_user = $record->employee->user;
                            $division_user->notify(
                                Notification::make('Permintaan Diterima')
                                    ->title('Permintaan: ' . $record->id . ' Diterima')
                                    ->body("Silahkan ambil barang ke gudang")
                                    ->success()
                                    ->toDatabase()
                            );

                            return redirect()->route('filament.supervisor.resources.request-items.index');
                        })
                        ->visible(fn($livewire): bool => $livewire instanceof ViewRecord)  // display on ViewRecord Only
                        ->hidden(fn(RequestItem $record): bool => $record->status !== 'diajukan'),  // hidden if status is not 'diajukan'
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
                        ->action(function (RequestItem $record, array $data) {
                            Notification::make()
                                ->title('Berhasil merubah status Permintaan')
                                ->success()
                                ->send()
                                ->toDatabase();

                            $record->update(['status' => 'ditolak']);
                            $division_user = $record->employee->user;
                            $division_user->notify(
                                Notification::make('Permintaan Ditolak')
                                    ->title('Permintaan: ' . $record->id . ' Ditolak')
                                    ->body("Alasan ditolak: " . $data['alasan_ditolak'])
                                    ->danger()
                                    ->toDatabase()
                            );

                            return redirect()->route('filament.supervisor.resources.request-items.index');
                        })
                        ->visible(fn($livewire): bool => $livewire instanceof ViewRecord)
                        ->hidden(fn(RequestItem $record): bool => $record->status !== 'diajukan'),
                ])
                ->footerActionsAlignment(Alignment::Center),
        ]);
    }
}
