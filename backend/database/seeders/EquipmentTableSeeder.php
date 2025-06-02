<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment')->insert([
            // 14 tipos de armas (2 de cada)
            ['equipment_name' => 'Iron Great Sword',      'equipment_type' => 1,  'equipment_stat' => 80,  'equipment_description' => 'A heavy sword with great power.', 'equipment_image' => 'equipment_image/iron_great_sword.png'],
            ['equipment_name' => 'Wyvern Jawblade',       'equipment_type' => 1,  'equipment_stat' => 120, 'equipment_description' => 'A massive blade made from wyvern jaws.', 'equipment_image' => 'equipment_image/wyvern_jawblade.png'],

            ['equipment_name' => 'Iron Katana',           'equipment_type' => 2,  'equipment_stat' => 70,  'equipment_description' => 'A sharp and agile long sword.', 'equipment_image' => 'equipment_image/iron_katana.png'],
            ['equipment_name' => 'Hidden Saber',          'equipment_type' => 2,  'equipment_stat' => 110, 'equipment_description' => 'A long sword with a mysterious aura.', 'equipment_image' => 'equipment_image/hidden_saber.png'],

            ['equipment_name' => 'Hunter\'s Knife',       'equipment_type' => 3,  'equipment_stat' => 30,  'equipment_description' => 'A basic sword and shield set.', 'equipment_image' => 'equipment_image/hunters_knife.png'],
            ['equipment_name' => 'Carapace Slicer',       'equipment_type' => 3,  'equipment_stat' => 55,  'equipment_description' => 'A sword and shield made from monster carapace.', 'equipment_image' => 'equipment_image/carapace_slicer.png'],

            ['equipment_name' => 'Dual Daggers',          'equipment_type' => 4,  'equipment_stat' => 40,  'equipment_description' => 'Fast and light dual blades.', 'equipment_image' => 'equipment_image/dual_daggers.png'],
            ['equipment_name' => 'Blazing Twinblades',    'equipment_type' => 4,  'equipment_stat' => 65,  'equipment_description' => 'Dual blades imbued with fire.', 'equipment_image' => 'equipment_image/blazing_twinblades.png'],

            ['equipment_name' => 'Iron Hammer',           'equipment_type' => 5,  'equipment_stat' => 90,  'equipment_description' => 'A heavy iron hammer.', 'equipment_image' => 'equipment_image/iron_hammer.png'],
            ['equipment_name' => 'Bone Bludgeon',         'equipment_type' => 5,  'equipment_stat' => 130, 'equipment_description' => 'A hammer made from monster bones.', 'equipment_image' => 'equipment_image/bone_bludgeon.png'],

            ['equipment_name' => 'Metal Bagpipe',         'equipment_type' => 6,  'equipment_stat' => 60,  'equipment_description' => 'A hunting horn that boosts allies.', 'equipment_image' => 'equipment_image/metal_bagpipe.png'],
            ['equipment_name' => 'Great Bagpipe',         'equipment_type' => 6,  'equipment_stat' => 100, 'equipment_description' => 'A large horn with powerful melodies.', 'equipment_image' => 'equipment_image/great_bagpipe.png'],

            ['equipment_name' => 'Iron Lance',            'equipment_type' => 7,  'equipment_stat' => 85,  'equipment_description' => 'A sturdy lance for defense.', 'equipment_image' => 'equipment_image/iron_lance.png'],
            ['equipment_name' => 'Knight Lance',          'equipment_type' => 7,  'equipment_stat' => 120, 'equipment_description' => 'A lance used by royal knights.', 'equipment_image' => 'equipment_image/knight_lance.png'],

            ['equipment_name' => 'Iron Gunlance',         'equipment_type' => 8,  'equipment_stat' => 95,  'equipment_description' => 'A lance with explosive power.', 'equipment_image' => 'equipment_image/iron_gunlance.png'],
            ['equipment_name' => 'Chrome Gunlance',       'equipment_type' => 8,  'equipment_stat' => 140, 'equipment_description' => 'A gunlance with a chrome finish.', 'equipment_image' => 'equipment_image/chrome_gunlance.png'],

            ['equipment_name' => 'Switch Axe',            'equipment_type' => 9,  'equipment_stat' => 100, 'equipment_description' => 'A weapon that switches between axe and sword.', 'equipment_image' => 'equipment_image/switch_axe.png'],
            ['equipment_name' => 'Power Axe',             'equipment_type' => 9,  'equipment_stat' => 150, 'equipment_description' => 'A switch axe with immense power.', 'equipment_image' => 'equipment_image/power_axe.png'],

            ['equipment_name' => 'Charge Blade',          'equipment_type' => 10, 'equipment_stat' => 110, 'equipment_description' => 'A blade that charges energy.', 'equipment_image' => 'equipment_image/charge_blade.png'],
            ['equipment_name' => 'Impact Charge Blade',   'equipment_type' => 10, 'equipment_stat' => 160, 'equipment_description' => 'A charge blade with impact phial.', 'equipment_image' => 'equipment_image/impact_charge_blade.png'],

            ['equipment_name' => 'Insect Glaive',         'equipment_type' => 11, 'equipment_stat' => 75,  'equipment_description' => 'A glaive that controls kinsects.', 'equipment_image' => 'equipment_image/insect_glaive.png'],
            ['equipment_name' => 'Empress Cane',          'equipment_type' => 11, 'equipment_stat' => 120, 'equipment_description' => 'A glaive with royal design.', 'equipment_image' => 'equipment_image/empress_cane.png'],

            ['equipment_name' => 'Hunter\'s Bow',         'equipment_type' => 12, 'equipment_stat' => 60,  'equipment_description' => 'A basic bow for hunters.', 'equipment_image' => 'equipment_image/hunters_bow.png'],
            ['equipment_name' => 'Dragonbone Bow',        'equipment_type' => 12, 'equipment_stat' => 110, 'equipment_description' => 'A bow made from dragon bones.', 'equipment_image' => 'equipment_image/dragonbone_bow.png'],

            ['equipment_name' => 'Light Bowgun',          'equipment_type' => 13, 'equipment_stat' => 70,  'equipment_description' => 'A lightweight bowgun for rapid fire.', 'equipment_image' => 'equipment_image/light_bowgun.png'],
            ['equipment_name' => 'Blizzard Cannon',       'equipment_type' => 13, 'equipment_stat' => 120, 'equipment_description' => 'A bowgun that shoots freezing rounds.', 'equipment_image' => 'equipment_image/blizzard_cannon.png'],

            ['equipment_name' => 'Heavy Bowgun',          'equipment_type' => 14, 'equipment_stat' => 90,  'equipment_description' => 'A heavy bowgun with high firepower.', 'equipment_image' => 'equipment_image/heavy_bowgun.png'],
            ['equipment_name' => 'Destruction Cannon',    'equipment_type' => 14, 'equipment_stat' => 150, 'equipment_description' => 'A bowgun that can destroy anything.', 'equipment_image' => 'equipment_image/destruction_cannon.png'],

            // 5 partes de armadura (2 de cada)
            ['equipment_name' => 'Leather Headgear',      'equipment_type' => 15, 'equipment_stat' => 10,  'equipment_description' => 'Basic head protection.', 'equipment_image' => 'equipment_image/leather_headgear.png'],
            ['equipment_name' => 'Rathalos Helm',         'equipment_type' => 15, 'equipment_stat' => 40,  'equipment_description' => 'Helmet crafted from Rathalos.', 'equipment_image' => 'equipment_image/rathalos_helm.png'],

            ['equipment_name' => 'Leather Mail',          'equipment_type' => 16, 'equipment_stat' => 15,  'equipment_description' => 'Basic chest armor.', 'equipment_image' => 'equipment_image/leather_mail.png'],
            ['equipment_name' => 'Rathalos Mail',         'equipment_type' => 16, 'equipment_stat' => 50,  'equipment_description' => 'Chest armor made from Rathalos.', 'equipment_image' => 'equipment_image/rathalos_mail.png'],

            ['equipment_name' => 'Leather Gloves',        'equipment_type' => 17, 'equipment_stat' => 8,   'equipment_description' => 'Basic arm protection.', 'equipment_image' => 'equipment_image/leather_gloves.png'],
            ['equipment_name' => 'Rathalos Vambraces',    'equipment_type' => 17, 'equipment_stat' => 35,  'equipment_description' => 'Arm guards made from Rathalos.', 'equipment_image' => 'equipment_image/rathalos_vambraces.png'],

            ['equipment_name' => 'Leather Belt',          'equipment_type' => 18, 'equipment_stat' => 7,   'equipment_description' => 'Basic waist protection.', 'equipment_image' => 'equipment_image/leather_belt.png'],
            ['equipment_name' => 'Rathalos Coil',         'equipment_type' => 18, 'equipment_stat' => 30,  'equipment_description' => 'Waist armor made from Rathalos.', 'equipment_image' => 'equipment_image/rathalos_coil.png'],

            ['equipment_name' => 'Leather Pants',         'equipment_type' => 19, 'equipment_stat' => 12,  'equipment_description' => 'Basic leg protection.', 'equipment_image' => 'equipment_image/leather_pants.png'],
            ['equipment_name' => 'Rathalos Greaves',      'equipment_type' => 19, 'equipment_stat' => 45,  'equipment_description' => 'Leg armor made from Rathalos.', 'equipment_image' => 'equipment_image/rathalos_greaves.png'],
        ]);
    }
}