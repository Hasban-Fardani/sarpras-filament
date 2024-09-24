<?php

namespace Database\Seeders;

use App\Models\SubmissionItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubmissionItem::create([
            'division_id' => '3',
            'status' => 'diajukan',
        ]);

        SubmissionItem::create([
            'division_id' => '4',
            'status' => 'diajukan',
        ]);

        SubmissionItem::create([
            'division_id' => '3',
            'status' => 'diajukan',
        ]);
        
        SubmissionItem::create([
            'division_id' => '4',
            'status' => 'diajukan',
        ]);
        
        SubmissionItem::create([
            'division_id' => '4',
            'status' => 'diajukan',
        ]);
        
        SubmissionItem::create([
            'division_id' => '4',
            'status' => 'diajukan',
        ]);
    }
}
