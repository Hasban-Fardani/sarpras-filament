<?php

namespace Database\Seeders;

use App\Models\IncomingItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incomingItems = [
            [
                'employee_id' => '2',
                'supplier_id' => '1',
                'note' => 'Barang masuk untuk keperluan testing'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '2',
                'note' => 'Barang masuk untuk keperluan testing'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '3',
                'note' => 'Barang masuk untuk keperluan testing'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '4',
                'note' => 'Barang masuk untuk keperluan testing'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '5',
                'note' => 'Barang masuk untuk keperluan testing'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '1',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-01-01 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '2',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-01-15 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '3',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-02-20 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '4',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-02-10 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '5',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-03-25 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '1',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-06-05 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '2',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-07-15 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '3',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-08-20 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '4',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-09-10 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '5',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-10-25 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '1',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-11-05 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '2',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-12-15 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '3',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-01-20 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '4',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-02-10 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '5',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-03-05 00:00:00'
            ],
            [
                'employee_id' => '2',
                'supplier_id' => '1',
                'note' => 'Barang masuk untuk keperluan testing',
                'created_at' => '2024-03-05 00:00:00'
            ]
        ];
        
        foreach ($incomingItems as $item) {
            IncomingItem::create($item);
        }
    }
}
