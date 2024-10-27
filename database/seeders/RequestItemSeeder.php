<?php

namespace Database\Seeders;

use App\Models\RequestItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 15; $i++) {
            RequestItem::create([
                'division_id' => fake()->numberBetween(3, 4),
                'operator_id' => '1',
                'status' => fake()->randomElement(['diajukan', 'draf', 'disetujui', 'ditolak']),
                'created_at' => fake()->dateTimeBetween('-4 months', 'now'),
            ]);
        }
    }
}
