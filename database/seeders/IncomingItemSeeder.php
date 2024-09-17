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
        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '1',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);

        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '2',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);

        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '3',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);

        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '4',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);

        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '5',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);

        IncomingItem::create([
            'employee_id' => '2',
            'supplier_id' => '1',
            'note' => 'Barang masuk untuk keperluan testing'
        ]);
    }
}
