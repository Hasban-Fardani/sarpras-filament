<?php

namespace Database\Seeders;

use App\Models\RequestItem;
use App\Models\RequestItemDetail;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RequestItemDetailSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($j = 1; $j < 15; $j++) {
            for ($i = 0; $i < fake()->numberBetween(3, 10); $i++) {
                RequestItemDetail::create([
                    'request_item_id' => $j,
                    'item_id' => $faker->randomElement(Item::all()->pluck('id')->toArray()),
                    'qty' => $faker->numberBetween(1, 100),
                ]);
            }
        }
    }
}