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
            'email' => 'toni@localhost.test',
            'role' => 'admin',
            'nip' => '1234567891'
        ]);

        User::factory()->create([
            'email' => 'sutarsa@localhost.test',
            'role' => 'supervisor',
            'nip' => '1234567890'
        ]);

        User::factory()->create([
            'email' => 'ani@localhost.test',
            'role' => 'division',
            'nip' => '1234567892'
        ]);
    }
}
