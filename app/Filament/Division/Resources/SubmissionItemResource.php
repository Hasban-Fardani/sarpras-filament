<?php

namespace App\Filament\Division\Resources;

use App\Filament\Division\Resources\SubmissionItemResource\Pages;
use App\Filament\Division\Resources\SubmissionItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\SubmissionItem;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SubmissionItemResource extends Resource
{
    protected static ?string $model = SubmissionItem::class;

    protected static ?string $navigationIcon = 'heroicon-m-shopping-cart';

    protected static ?string $navigationLabel = 'Pengadaan Barang';

    protected static ?string $pluralModelLabel = 'Pengadaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi')->schema([
                    Forms\Components\Select::make('division_id')
                        ->label('Pengaju')
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->default(Auth::id()),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'draf' => 'Draf',
                            'diajukan' => 'Diajukan',
                        ])
                        ->hidden(fn ($livewire): bool => $livewire instanceof CreateRecord)
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $user->load('employee');
        return $table
            ->query(SubmissionItem::where('division_id', $user->employee->id))
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
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
                    ->label('Jumlah Barang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Ajukan')
                    ->color(Color::Green)
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Ajukan Pengadaan')
                    ->modalDescription('Pengajuan pengadaan akan diajukan')
                    ->action(function (SubmissionItem $record) {
                        $record->update([
                            'status' => 'diajukan',
                        ]);
                    })
                    ->modalSubmitActionLabel('Kirim')
                    ->modalCancelActionLabel('Batal')
                    ->modalSubmitAction(fn(StaticAction $action) => $action->color(Color::Green))
                    ->hidden(function (SubmissionItem $record) {
                        return $record->status !== 'draf';
                    }),
            Tables\Actions\EditAction::make()
                    ->color(Color::Yellow),
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
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubmissionItems::route('/'),
            'create' => Pages\CreateSubmissionItem::route('/create'),
            'edit' => Pages\EditSubmissionItem::route('/{record}/edit'),
        ];
    }
}
