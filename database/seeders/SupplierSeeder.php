<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'Supplier 1',
            'address' => 'Address 1',
            'phone' => '08123456789',
        ]);

        Supplier::create([
            'name' => 'Supplier 2',
            'address' => 'Address 2',
            'phone' => '08123456790',
        ]);

        Supplier::create([
            'name' => 'Supplier 3',
            'address' => 'Address 3',
            'phone' => '08123456791',
        ]);

        Supplier::create([
            'name' => 'Supplier 4',
            'address' => 'Address 4',
            'phone' => '08123456792',
        ]);

        Supplier::create([
            'name' => 'Supplier 5',
            'address' => 'Address 5',
            'phone' => '08123456793',
        ]);
    }
}
