<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert data seeder to users table
        DB::table('users')->insert(
            [
                ['name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('rahasia123'),
                'role' => '1',
                ],
                [
                    'name' => 'Author',
                    'username' => 'author',
                    'email' => 'author@gmail.com',
                    'password' => bcrypt('rahasia123'),
                    'role' => '10',
                ],
            ],
        );
    }
}
