<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment')->insert([
            ['equipment_name' => 'Sword', 'equipment_type' => 1, 'equipment_stat'=>25, 'equipment_description'=>'Fast paced short-range weapon', 'equipment_image'=>'path'],
['equipment_name' => 'Helmet', 'equipment_type_id' => 2, 'equipment_stat'=>50, 'equipment_description'=>'Slow motion short-range weapon', 'equipment_image'=>'path'],
['equipment_name' => 'Ring of Strength', 'equipment_type_id' => 3, 'equipment_stat'=>15, 'equipment_description'=>'Protection against magic', 'equipment_image'=>'path'],
['equipment_name' => 'Pickaxe', 'equipment_type_id' => 4, 'equipment_stat'=>30, 'equipment_description'=>'Blunt damage weapon', 'equipment_image'=>'path']
        ]);
    }
}
