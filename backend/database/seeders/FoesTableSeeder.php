<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('foes')->insert([
            ['foe_name' => 'Wolf', 'foe_type' => 1, 'foe_size'=>'Big', 'foe_description'=>'AAaa', 'foe_icon'=>'path', 'foe_image'=>'path'],
['foe_name' => 'Zombie', 'foe_type' => 2, 'foe_size'=>'Big', 'foe_description'=>'AAaa', 'foe_icon'=>'path', 'foe_image'=>'path'],
['foe_name' => 'Fire Dragon', 'foe_type' => 3, 'foe_size'=>'Big', 'foe_description'=>'AAaa', 'foe_icon'=>'path', 'foe_image'=>'path'],
['foe_name' => 'Water Elemental', 'foe_type' => 4, 'foe_size'=>'Big', 'foe_description'=>'AAaa', 'foe_icon'=>'path', 'foe_image'=>'path']
        ]);
    }
}
