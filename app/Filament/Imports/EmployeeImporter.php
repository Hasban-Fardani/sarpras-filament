<?php

namespace App\Filament\Imports;

use App\Models\Employee;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nip')
                ->label('nip')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('position')
                ->label('jabatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('phone')
                ->label('telepon')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->label('email')
                ->rules(['email', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        // Check if employee with the same NIP already exists
        $employee = Employee::where('nip', $this->data['nip'])->first();
        
        if ($employee) {
            // Update existing employee
            $employee->update([
                'name' => $this->data['name'],
                'position' => $this->data['position'],
                'phone' => $this->data['phone'] ?? null,
                'email' => $this->data['email'] ?? null,
            ]);
            
            return $employee;
        }
        
        // Create new employee
        return Employee::create([
            'name' => $this->data['name'],
            'nip' => $this->data['nip'],
            'position' => $this->data['position'],
            'phone' => $this->data['phone'] ?? null,
            'email' => $this->data['email'] ?? null,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}