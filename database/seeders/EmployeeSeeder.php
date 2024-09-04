<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            "name" => "Sutarsa",
            "email" => "sutarsa@localhost.test",
            'position' => 'Wakasek Sarana Prasarana',
            "nip" => "1234567890"
        ]);
        
        Employee::create([
            "name" => "Toni",
            "email" => "toni@localhost.test",
            'position' => 'Petugas Sarana prasarana',
            "nip" => "1234567891"
        ]);

        Employee::create([
            "name" => "Ani",
            "email" => "ani@localhost.test",
            'position' => 'Ketua Program RPL',
            "nip" => "1234567892"
        ]);

        Employee::create([
            "name" => "Zim zim",
            "email" => "zim.zim@localhost.test",
            'position' => 'Ketua Program DKV',
            "nip" => "1234567893"
        ]);

        Employee::create([
            "name" => "Sri",
            "email" => "sri@localhost.test",
            'position' => 'Kepala Sekolah',
            "nip" => "1234567894"
        ]);
    }
}
