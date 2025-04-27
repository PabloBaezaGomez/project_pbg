<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialEquipmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_equipment')->insert([
            ['material_id' => 1, 'equipment_id' => 1, 'required_quantity' => 10],
            ['material_id' => 1, 'equipment_id' => 2, 'required_quantity' => 5],
            ['material_id' => 2, 'equipment_id' => 1, 'required_quantity' => 8],
            ['material_id' => 2, 'equipment_id' => 3, 'required_quantity' => 12],
            ['material_id' => 3, 'equipment_id' => 1, 'required_quantity' => 15],
            ['material_id' => 3, 'equipment_id' => 4, 'required_quantity' => 20],
            ['material_id' => 4, 'equipment_id' => 2, 'required_quantity' => 25],
            ['material_id' => 4, 'equipment_id' => 3, 'required_quantity' => 30],
            ['material_id' => 1, 'equipment_id' => 3, 'required_quantity' => 7],
            ['material_id' => 2, 'equipment_id' => 4, 'required_quantity' => 9],
            ['material_id' => 3, 'equipment_id' => 2, 'required_quantity' => 11],
            ['material_id' => 4, 'equipment_id' => 1, 'required_quantity' => 13],
        ]);
    }
}
