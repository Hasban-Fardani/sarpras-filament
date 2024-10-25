<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubmissionItemResource\Pages;
use App\Filament\Admin\Resources\SubmissionItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\SubmissionItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    protected static ?string $navigationGroup = 'Pengajuan';

    protected static ?string $pluralModelLabel = 'Pengadaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\Select::make('division_id')
                        ->label('Pengaju')
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->required()
                        ->default(Auth::user()->employee->id),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'draf' => 'Draf',
                            'diajukan' => 'Diajukan'
                        ])
                        ->default('draf')
                        ->required()
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
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
                    ->label('Jumlah Item')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'view' => Pages\ViewSubmissionItem::route('/{record}'),
            'edit' => Pages\EditSubmissionItem::route('/{record}/edit'),
        ];
    }
}
