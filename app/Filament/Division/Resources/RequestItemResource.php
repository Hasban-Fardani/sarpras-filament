<?php

namespace App\Filament\Division\Resources;

use App\Filament\Division\Resources\RequestItemResource\Pages;
use App\Filament\Division\Resources\RequestItemResource\RelationManagers;
use App\Models\Employee;
use App\Models\RequestItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RequestItemResource extends Resource
{
    protected static ?string $model = RequestItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';

    protected static ?string $navigationLabel = 'Permintaan Barang';

    protected static ?string $pluralModelLabel = 'Permintaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi')->schema([
                    Forms\Components\Select::make('division_id')
                        ->label('Pengaju')
                        ->options(Employee::all()->pluck('name', 'id'))
                        ->default(Auth::user()->employee->id)
                        ->disabled(fn($livewire): bool => $livewire instanceof EditRecord),
                    Forms\Components\Select::make('status')
                        ->options([
                            'draf' => 'Draf',
                            'diajukan' => 'Diajukan',
                        ])
                        ->default('draf')
                        ->disabled()
                        ->hidden(fn($livewire): bool => $livewire instanceof CreateRecord),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $user->load('employee');
        return $table
            ->query(RequestItem::where('division_id', $user->employee->id)->latest())
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
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequestItems::route('/'),
            'create' => Pages\CreateRequestItem::route('/create'),
            'edit' => Pages\EditRequestItem::route('/{record}/edit'),
        ];
    }
}
