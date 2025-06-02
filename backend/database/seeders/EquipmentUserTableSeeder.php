<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentUserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_user')->insert([
            // User 1: 3 weapons (1,2,3) and 2 armor (29,30)
            ['equipment_id' => 1, 'user_id' => 1], // Great Sword
            ['equipment_id' => 2, 'user_id' => 1], // Wyvern Jawblade
            ['equipment_id' => 3, 'user_id' => 1], // Iron Katana
            ['equipment_id' => 29, 'user_id' => 1], // Leather Headgear
            ['equipment_id' => 30, 'user_id' => 1], // Rathalos Helm

            // User 2: 3 weapons (4,5,6) and 2 armor (31,32)
            ['equipment_id' => 4, 'user_id' => 2], // Hidden Saber
            ['equipment_id' => 5, 'user_id' => 2], // Hunter's Knife
            ['equipment_id' => 6, 'user_id' => 2], // Carapace Slicer
            ['equipment_id' => 31, 'user_id' => 2], // Leather Mail
            ['equipment_id' => 32, 'user_id' => 2], // Rathalos Mail

            // User 3: 3 weapons (7,8,9) and 2 armor (33,34)
            ['equipment_id' => 7, 'user_id' => 3], // Dual Daggers
            ['equipment_id' => 8, 'user_id' => 3], // Blazing Twinblades
            ['equipment_id' => 9, 'user_id' => 3], // Iron Hammer
            ['equipment_id' => 33, 'user_id' => 3], // Leather Gloves
            ['equipment_id' => 34, 'user_id' => 3], // Rathalos Vambraces

            // User 4: 3 weapons (10,11,12) and 2 armor (35,36)
            ['equipment_id' => 10, 'user_id' => 4], // Bone Bludgeon
            ['equipment_id' => 11, 'user_id' => 4], // Metal Bagpipe
            ['equipment_id' => 12, 'user_id' => 4], // Great Bagpipe
            ['equipment_id' => 35, 'user_id' => 4], // Leather Belt
            ['equipment_id' => 36, 'user_id' => 4], // Rathalos Coil
        ]);
    }
}