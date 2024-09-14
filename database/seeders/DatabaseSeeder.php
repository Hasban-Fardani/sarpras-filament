<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            EmployeeSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            ItemSeeder::class,
            IncomingItemSeeder::class,
            IncomingItemDetailSeeder::class,
            OutgoingItemSeeder::class,
            SubmissionItemSeeder::class,
            RequestItemSeeder::class,
        ]);
    }
}
