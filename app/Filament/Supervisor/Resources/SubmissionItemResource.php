<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\SubmissionItemResource\Pages;
use App\Filament\Supervisor\Resources\SubmissionItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\SubmissionItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionItemResource extends Resource
{
    protected static ?string $model = SubmissionItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Pengaju')
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
                    })
                    ->sortable(),
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
            //
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
