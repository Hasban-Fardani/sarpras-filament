<?php

namespace Database\Seeders;

use App\Models\OutgoingItemDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutgoingItemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OutgoingItemDetail::create([
            'outgoing_item_id' => '1',
            'item_id' => '1',
            'qty' => 12
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '1',
            'item_id' => '2',
            'qty' => 15
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '2',
            'item_id' => '1',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '2',
            'item_id' => '2',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '3',
            'item_id' => '1',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '3',
            'item_id' => '2',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '4',
            'item_id' => '1',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '4',
            'item_id' => '2',
            'qty' => 10
        ]);

        OutgoingItemDetail::create([
            'outgoing_item_id' => '5',
            'item_id' => '1',
            'qty' => 10
        ]);
    }
}
