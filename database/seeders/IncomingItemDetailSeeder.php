<?php

namespace Database\Seeders;

use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IncomingItemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $item_ids = Item::all()->pluck('id')->toArray();
        for ($j = 1; $j < 16; $j++) {
            for ($i = 0; $i < 5; $i++) {
                IncomingItemDetail::create([
                    'incoming_item_id' => $j,
                    'item_id' => $faker->randomElement($item_ids),
                    'qty' => $faker->numberBetween(20, 100),
                ]);
            }
        }
    }
}
