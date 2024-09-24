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
        RequestItem::create([
            'employee_id' => '3',
            'status' => 'diajukan',
        ]);

        RequestItem::create([
            'employee_id' => '4',
            'status' => 'diajukan',
        ]);

        RequestItem::create([
            'employee_id' => '4',
            'status' => 'diajukan',
        ]);

        RequestItem::create([
            'employee_id' => '3',
            'status' => 'diajukan',
        ]);

        RequestItem::create([
            'employee_id' => '4',
            'status' => 'diajukan',
        ]);
    }
}
