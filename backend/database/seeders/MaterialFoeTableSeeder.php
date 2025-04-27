<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialFoeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_foe')->insert([
            ['material_id' => 1, 'foe_id' => 1, 'drop_rate' => 0.25],
            ['material_id' => 1, 'foe_id' => 2, 'drop_rate' => 0.50],
            ['material_id' => 1, 'foe_id' => 3, 'drop_rate' => 0.75],
            ['material_id' => 1, 'foe_id' => 4, 'drop_rate' => 1.00],
        ]);
    }
}
