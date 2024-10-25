<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use RequestItemDetailSeeder;

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
            OutgoingItemDetailSeeder::class,
            SubmissionItemSeeder::class,
            SubmissionItemDetailSeeder::class,
            RequestItemSeeder::class,
            RequestItemDetailSeeder::class
        ]);
    }
}
