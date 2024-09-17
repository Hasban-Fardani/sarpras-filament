<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'image' => 'pulpen-joyko-gp-265.jpeg',
            'name' => 'Pulpen Joyko',
            'unit' => 'Buah',
            'merk' => 'Joyko',
            'size' => '0.25mm',
            'type' => 'pulpen gel',
            'price' => 2000,
            'stock' => 10,
            'min_stock' => 15,
            'category_id' => 1
        ]);

        Item::create([
            'image' => 'pulpen-ae7.jpeg',
            'name' => 'Pulpen EA7',
            'unit' => 'Buah',
            'merk' => 'EA7',
            'size' => '0.7mm',
            'type' => 'bolpoint',
            'price' => 1500,
            'stock' => 10,
            'min_stock' => 5,
            'category_id' => 1
        ]);

        Item::create([
            'image' => 'spidol-snowman-boardmarker.jpeg',
            'name' => 'Spidol snowman',
            'unit' => 'Buah',
            'merk' => 'Snowman',
            'type' => 'spidol board marker',
            'size' => '1cm',
            'price' => 10000,
            'stock' => 10,
            'min_stock' => 5,
            'category_id' => 1
        ]);

        Item::create([
            'image' => 'buku-sidu-38.jpeg',
            'name' => 'Buku sidu 38',
            'unit' => 'Rim',
            'type' => 'kertas hvs',
            'size' => '38',
            'merk' => 'sidu',
            'price' => 5000,
            'stock' => 10,
            'min_stock' => 5,
            'category_id' => 1
        ]);

        Item::create([
            'image' => 'kertas-sidu-a4.jpeg',
            'name' => 'Kertas A4 sidu',
            'unit' => 'Rim',
            'type' => 'kertas hvs',
            'size' => 'A5',
            'merk' => 'sidu',
            'price' => 15000,
            'stock' => 10,
            'min_stock' => 5,
            'category_id' => 1
        ]);
    }
}
