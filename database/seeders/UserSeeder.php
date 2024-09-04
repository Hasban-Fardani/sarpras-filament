<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Toni',
            'email' => 'toni@localhost.test',
            'role' => 'admin',
            'nip' => '1234567891'
        ]);

        User::factory()->create([
            'name' => 'Sutarsa',
            'email' => 'sutarsa@localhost.test',
            'role' => 'supervisor',
            'nip' => '1234567890'
        ]);
    }
}
