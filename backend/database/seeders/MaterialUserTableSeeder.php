<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialUserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_user')->insert([
            ['user_id' => 1, 'material_id' => 1, 'quantity' => 10],
            ['user_id' => 1, 'material_id' => 2, 'quantity' => 5],
            ['user_id' => 2, 'material_id' => 1, 'quantity' => 3],
            ['user_id' => 2, 'material_id' => 3, 'quantity' => 7],
            ['user_id' => 3, 'material_id' => 4, 'quantity' => 2],
            ['user_id' => 4, 'material_id' => 1, 'quantity' => 8],
        ]);
    }
}
