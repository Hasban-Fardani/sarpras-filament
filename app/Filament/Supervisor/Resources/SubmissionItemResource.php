<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\SubmissionItemResource\Pages;
use App\Filament\Supervisor\Resources\SubmissionItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\SubmissionItem;
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
                        ->required(),
                    Forms\Components\TextInput::make('status')
                        ->required()
                        ->disabled(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(SubmissionItem::where('status', '<>', 'draf'))
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
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
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total barang Diajukan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items_acc')
                    ->label('Total barang Disetujui')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListSubmissionItems::route('/'),
            'view' => Pages\ViewSubmissionItem::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
