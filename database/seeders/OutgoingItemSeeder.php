<?php

namespace Database\Seeders;

use App\Models\OutgoingItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutgoingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OutgoingItem::create([
            'operator_id' => '2',
            'division_id' => '3',
            'item_id' => '1',
            'qty' => 10,
            'note' => 'Barang keluar untuk keperluan testing'
        ]);

        OutgoingItem::create([
            'operator_id' => '2',
            'division_id' => '3',
            'item_id' => '1',
            'qty' => 10,
            'note' => 'Barang keluar untuk'
        ]);

        OutgoingItem::create([
            'operator_id' => '2',
            'division_id' => '4',
            'item_id' => '1',
            'qty' => 10,
            'note' => 'Barang keluar untuk'
        ]);

        OutgoingItem::create([
            'operator_id' => '2',
            'division_id' => '4',
            'item_id' => '1',
            'qty' => 10,
            'note' => 'Barang keluar untuk'
        ]);

        OutgoingItem::create([
            'operator_id' => '2',
            'division_id' => '4',
            'item_id' => '1',
            'qty' => 10,
            'note' => 'Barang keluar untuk'
        ]);
    }
}
