<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_types')->insert([
            ['material_type_name' => 'Metal', 'material_type_icon'=>'path'],
['material_type_name' => 'Wood', 'material_type_icon'=>'path'],
['material_type_name' => 'Stone', 'material_type_icon'=>'path'],
['material_type_name' => 'Fabric', 'material_type_icon'=>'path']
        ]);
    }
}
