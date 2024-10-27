<?php

namespace Database\Seeders;

use App\Models\Item;
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
        $item_ids = Item::all()->pluck('id')->toArray();
        for ($i = 0; $i < 100; $i++) {
            OutgoingItemDetail::create([
                'outgoing_item_id' => fake()->numberBetween(1, 15),
                'item_id' => fake()->randomElement($item_ids),
                'qty' => fake()->numberBetween(5, 30),
            ]);
        }
    }
}
