<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialUserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_user')->insert([
            // User 1
            ['user_id' => 1, 'material_id' => 1, 'quantity' => 10], // Monster Bone S
            ['user_id' => 1, 'material_id' => 4, 'quantity' => 7],  // Rathalos Scale
            ['user_id' => 1, 'material_id' => 10, 'quantity' => 5], // Iron Ore
            ['user_id' => 1, 'material_id' => 13, 'quantity' => 2], // Monster Fluid
            ['user_id' => 1, 'material_id' => 16, 'quantity' => 3], // Jagras Hide

            // User 2
            ['user_id' => 2, 'material_id' => 2, 'quantity' => 8],  // Monster Bone M
            ['user_id' => 2, 'material_id' => 5, 'quantity' => 4],  // Jagras Scale
            ['user_id' => 2, 'material_id' => 11, 'quantity' => 6], // Machalite Ore
            ['user_id' => 2, 'material_id' => 17, 'quantity' => 1], // Anjanath Pelt

            // User 3
            ['user_id' => 3, 'material_id' => 3, 'quantity' => 12], // Monster Bone L
            ['user_id' => 3, 'material_id' => 6, 'quantity' => 3],  // Barroth Claw
            ['user_id' => 3, 'material_id' => 12, 'quantity' => 2], // Dragonite Ore
            ['user_id' => 3, 'material_id' => 19, 'quantity' => 2], // Rathalos Fang

            // User 4
            ['user_id' => 4, 'material_id' => 7, 'quantity' => 5],  // Rathian Claw
            ['user_id' => 4, 'material_id' => 8, 'quantity' => 2],  // Great Jagras Claw
            ['user_id' => 4, 'material_id' => 14, 'quantity' => 4], // Monster Broth
            ['user_id' => 4, 'material_id' => 22, 'quantity' => 1], // Rathalos Shell
        ]);
    }
}