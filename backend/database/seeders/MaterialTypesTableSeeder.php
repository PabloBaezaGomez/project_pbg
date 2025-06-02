<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_types')->insert([
            ['material_type_name' => 'Bone',        'material_type_icon' => 'material_type/bone.png'],
            ['material_type_name' => 'Scale',       'material_type_icon' => 'material_type/scale.png'],
            ['material_type_name' => 'Claw',        'material_type_icon' => 'material_type/claw.png'],
            ['material_type_name' => 'Hide',        'material_type_icon' => 'material_type/hide.png'],
            ['material_type_name' => 'Shell',       'material_type_icon' => 'material_type/shell.png'],
            ['material_type_name' => 'Ore',         'material_type_icon' => 'material_type/ore.png'],
            ['material_type_name' => 'Monster Fluid','material_type_icon' => 'material_type/monster_fluid.png'],
            ['material_type_name' => 'Tail',        'material_type_icon' => 'material_type/tail.png'],
            ['material_type_name' => 'Webbing',     'material_type_icon' => 'material_type/webbing.png'],
            ['material_type_name' => 'Gem',        'material_type_icon' => 'material_type/gem.png'],
        ]);
    }
}