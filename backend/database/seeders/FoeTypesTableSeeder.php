<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoeTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('foe_types')->insert([
            ['foe_type_name' => 'Beast'],
['foe_type_name' => 'Undead'],
['foe_type_name' => 'Dragon'],
['foe_type_name' => 'Elemental']
        ]);
    }
}
