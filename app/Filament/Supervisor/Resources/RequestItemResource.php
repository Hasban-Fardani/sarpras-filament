<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\RequestItemResource\Pages;
use App\Filament\Supervisor\Resources\RequestItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\OutgoingItem;
use App\Models\RequestItem;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RequestItemResource extends Resource
{
    protected static ?string $model = RequestItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Permintaan Barang';

    protected static ?string $pluralModelLabel = 'Permintaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi')->schema([
                    Forms\Components\Select::make('employee_id')
                        ->label('Pengaju')
                        ->required()
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->default(Auth::id())
                        ->disabled(),
                    Forms\Components\TextInput::make('status')
                        ->disabled(),
                ])
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
                            ->visible(fn($livewire): bool => $livewire instanceof EditRecord),
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
                            ->visible(fn($livewire): bool => $livewire instanceof EditRecord),
                    ])
                    ->footerActionsAlignment(Alignment::Center),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(RequestItem::where('status', '<>', 'draf'))
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function ($state) {
                        $colors = [
                            'draf' => 'secondary',
                            'diajukan' => 'warning',
                            'disetujui' => 'success',
                            'ditolak' => 'danger',
                        ];
                        return $colors[$state];
                    }),
                Tables\Columns\TextColumn::make('total_items')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequestItems::route('/'),
            'view' => Pages\ViewRequestItem::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
