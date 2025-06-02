<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoeTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('foe_types')->insert([
            ['foe_type_name' => 'Bird Wyvern'],
            ['foe_type_name' => 'Flying Wyvern'],
            ['foe_type_name' => 'Brute Wyvern'],
            ['foe_type_name' => 'Piscine Wyvern'],
            ['foe_type_name' => 'Fanged Wyvern'],
            ['foe_type_name' => 'Fanged Beast'],
            ['foe_type_name' => 'Elder Dragon'],
            ['foe_type_name' => 'Herbivore'],
            ['foe_type_name' => 'Neopteron'],
            ['foe_type_name' => 'Amphibian'],
            ['foe_type_name' => 'Leviathan'],
            ['foe_type_name' => 'Temnoceran'],
            ['foe_type_name' => 'Snake Wyvern'],
            ['foe_type_name' => 'Carapaceon'],
        ]);
    }
}