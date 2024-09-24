<?php

namespace App\Filament\Division\Resources;

use App\Filament\Division\Resources\OutgoingItemResource\Pages;
use App\Filament\Division\Resources\OutgoingItemResource\RelationManagers;
use App\Models\OutgoingItem;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OutgoingItemResource extends Resource
{
    protected static ?string $model = OutgoingItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Barang Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('operator_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('division_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_items')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $user->load('employee');
        return $table
            ->query(OutgoingItem::where('division_id', $user->employee->id))  # filter by current user
            ->columns([
                Tables\Columns\TextColumn::make('operator.name')
                    ->label('Petugas Gudang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_taken')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Sudah Diambil' : 'Belum Diambil')
                    ->color(fn($state) => $state ? 'success' : 'warning')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('diambil')
                    ->label('Sudah Diambil')
                    ->button()
                    ->modal()
                    ->modalHeading('Konfirmasi Ubah Status')
                    ->modalDescription('Apakah Anda yakin ingin mengubah status?')
                    ->action(function (OutgoingItem $record) {
                        $record->update(['is_taken' => true]);
                    })
                    ->hidden(fn(OutgoingItem $record) => $record->is_taken),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutgoingItems::route('/'),
            'view' => Pages\ViewOutgoingItem::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
