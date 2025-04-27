<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentUserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_user')->insert([
            ['equipment_id' => 1, 'user_id' => 1],
            ['equipment_id' => 2, 'user_id' => 2],
            ['equipment_id' => 3, 'user_id' => 3],
            ['equipment_id' => 4, 'user_id' => 4],
        ]);
    }
}
