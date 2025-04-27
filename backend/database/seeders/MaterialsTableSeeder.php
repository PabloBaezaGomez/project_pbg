<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('materials')->insert([
            ['material_name' => 'Iron Ore', 'material_type' => 1, 'material_rarity'=>'1', 'material_description'=>'AAAAAAA'],
['material_name' => 'Oak Wood', 'material_type' => 2, 'material_rarity'=>'1', 'material_description'=>'AAAAAAA'],
['material_name' => 'Granite', 'material_type' => 3, 'material_rarity'=>'1', 'material_description'=>'AAAAAAA'],
['material_name' => 'Silk', 'material_type' => 4, 'material_rarity'=>'1', 'material_description'=>'AAAAAAA']
        ]);
    }
}
