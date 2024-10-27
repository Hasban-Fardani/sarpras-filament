<?php

namespace Database\Seeders;

use App\Models\SubmissionItem;
use App\Models\SubmissionItemDetail;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class SubmissionItemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        SubmissionItem::all()->each(function ($submissionItem) use ($faker) {
            for ($i = 0; $i < 10; $i++) {
                SubmissionItemDetail::create([
                    'submission_item_id' => $submissionItem->id,
                    'item_id' => $faker->randomElement(Item::all()->pluck('id')->toArray()),
                    'qty' => $faker->numberBetween(20, 100),
                ]);
            }
        });
    }
}