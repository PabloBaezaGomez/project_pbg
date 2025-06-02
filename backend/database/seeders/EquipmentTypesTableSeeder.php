<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            // 14 Monster Hunter weapons types
            ['equipment_type_name' => 'Great Sword',      'equipment_type_icon' => 'equipment_type/great_sword.png'],
            ['equipment_type_name' => 'Long Sword',       'equipment_type_icon' => 'equipment_type/long_sword.png'],
            ['equipment_type_name' => 'Sword & Shield',   'equipment_type_icon' => 'equipment_type/sword_shield.png'],
            ['equipment_type_name' => 'Dual Blades',      'equipment_type_icon' => 'equipment_type/dual_blades.png'],
            ['equipment_type_name' => 'Hammer',           'equipment_type_icon' => 'equipment_type/hammer.png'],
            ['equipment_type_name' => 'Hunting Horn',     'equipment_type_icon' => 'equipment_type/hunting_horn.png'],
            ['equipment_type_name' => 'Lance',            'equipment_type_icon' => 'equipment_type/lance.png'],
            ['equipment_type_name' => 'Gunlance',         'equipment_type_icon' => 'equipment_type/gunlance.png'],
            ['equipment_type_name' => 'Switch Axe',       'equipment_type_icon' => 'equipment_type/switch_axe.png'],
            ['equipment_type_name' => 'Charge Blade',     'equipment_type_icon' => 'equipment_type/charge_blade.png'],
            ['equipment_type_name' => 'Insect Glaive',    'equipment_type_icon' => 'equipment_type/insect_glaive.png'],
            ['equipment_type_name' => 'Bow',              'equipment_type_icon' => 'equipment_type/bow.png'],
            ['equipment_type_name' => 'Light Bowgun',     'equipment_type_icon' => 'equipment_type/light_bowgun.png'],
            ['equipment_type_name' => 'Heavy Bowgun',     'equipment_type_icon' => 'equipment_type/heavy_bowgun.png'],

            // 5 Monster Hunter armor elements
            ['equipment_type_name' => 'Helmet',    'equipment_type_icon' => 'equipment_type/helmet.png'],
            ['equipment_type_name' => 'Chest',   'equipment_type_icon' => 'equipment_type/chest.png'],
            ['equipment_type_name' => 'Arms',    'equipment_type_icon' => 'equipment_type/arms.png'],
            ['equipment_type_name' => 'Waist',   'equipment_type_icon' => 'equipment_type/waist.png'],
            ['equipment_type_name' => 'Legs',    'equipment_type_icon' => 'equipment_type/legs.png'],
        ]);
    }
}
