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

        for ($j = 1; $j < 5; $j++) {

            for ($i = 0; $i < 3; $i++) {
                IncomingItemDetail::create([
                    'incoming_item_id' => $j,
                    'item_id' => Item::inRandomOrder()->first()->id,
                    'qty' => $faker->numberBetween(1, 10),
                ]);
            }
        }
    }
}
