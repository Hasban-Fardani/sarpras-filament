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
                            ->modalHeading('Tolak Laporan')
                            ->modalDescription('Laporan akan ditolak karena tidak sesuai')
                            ->modalSubmitActionLabel('Kirim')
                            ->modalCancelActionLabel('Batal')
                            ->modalSubmitAction(fn(StaticAction $action) => $action->color(Color::Blue))
                            ->action(function (RequestItem $record) {
                                $record->update(['status' => 'disetujui']);

                                $division_employee = $record->employee;

                                $items = [];

                                $record->details->each(function ($detail) use (&$items, $division_employee) {
                                    $items = array_merge($items, [
                                        'item_id' => $detail->item_id,
                                        'qty' => $detail->qty_acc,
                                        'division_id' => $division_employee->id,
                                        'operator_id' => Auth::user()->employee->id
                                    ]);
                                });

                                OutgoingItem::insert($items);

                                Notification::make()
                                    ->title('Berhasil merubah status Permintaan')
                                    ->success()
                                    ->send();

                                $division_user = $record->employee->user;
                                $division_user->notify(
                                    Notification::make('Revisi laporan')
                                        ->title('Permintaan: ' . $record->id . ' Diterima')
                                        ->body("Silahkan ambil barang ke gudang")
                                        ->success()
                                        ->toDatabase()
                                );
                            })
                            ->visible(fn($livewire): bool => $livewire instanceof EditRecord),
                        Action::make('tolak')
                            ->color('danger')
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
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Pengaju')
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditRequestItem::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
