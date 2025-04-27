<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            ['equipment_type_name' => 'Weapon', 'equipment_type_icon'=>'path'],
['equipment_type_name' => 'Armor', 'equipment_type_icon'=>'path'],
['equipment_type_name' => 'Accessory', 'equipment_type_icon'=>'path'],
['equipment_type_name' => 'Tool', 'equipment_type_icon'=>'path']
        ]);
    }
}
