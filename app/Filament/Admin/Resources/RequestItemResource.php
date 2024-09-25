<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RequestItemResource\Pages;
use App\Filament\Admin\Resources\RequestItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\RequestItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestItemResource extends Resource
{
    protected static ?string $model = RequestItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Permintaan Barang';

    protected static ?string $navigationGroup = 'Pengajuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('employee_id')
                        ->label('Nama Pengaju')
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->disabled(fn($livewire) => $livewire instanceof ViewRecord),
                    Forms\Components\Select::make('status')
                        ->options([
                            'draf' => 'Draf',
                            'diajukan' => 'Diajukan',
                        ])
                        ->default('draf')
                        ->disabled(fn($livewire) => $livewire instanceof CreateRecord)
                        ->hidden(fn($livewire) => $livewire instanceof CreateRecord),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
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
                    }),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total Item')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
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
            'index' => Pages\ListRequestItems::route('/'),
            'create' => Pages\CreateRequestItem::route('/create'),
            'view' => Pages\ViewRequestItem::route('/{record}'),
            'edit' => Pages\EditRequestItem::route('/{record}/edit'),
        ];
    }
}
