<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['user_name' => 'Alice', 'user_email' => 'alice@example.com', 'user_password' => bcrypt('password'), 'user_type' => 'admin'],
            ['user_name' => 'Bob', 'user_email' => 'bob@example.com', 'user_password' => bcrypt('password'), 'user_type' => 'user'],
            ['user_name' => 'Charlie', 'user_email' => 'charlie@example.com', 'user_password' => bcrypt('password'), 'user_type' => 'user'],
            ['user_name' => 'Diana', 'user_email' => 'diana@example.com', 'user_password' => bcrypt('password'), 'user_type' => 'user']
        ]);
    }
}
