<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialFoeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_foe')->insert([
            // Great Jaggi (Bird Wyvern)
            ['material_id' => 1, 'foe_id' => 1, 'drop_rate' => 0.30], // Monster Bone S
            ['material_id' => 4, 'foe_id' => 1, 'drop_rate' => 0.15], // Rathalos Scale
            ['material_id' => 8, 'foe_id' => 1, 'drop_rate' => 0.10], // Great Jagras Claw

            // Rathalos (Flying Wyvern)
            ['material_id' => 4, 'foe_id' => 2, 'drop_rate' => 0.50], // Rathalos Scale
            ['material_id' => 19, 'foe_id' => 2, 'drop_rate' => 0.20], // Rathalos Fang
            ['material_id' => 22, 'foe_id' => 2, 'drop_rate' => 0.15], // Rathalos Shell

            // Barroth (Brute Wyvern)
            ['material_id' => 6, 'foe_id' => 3, 'drop_rate' => 0.40], // Barroth Claw
            ['material_id' => 23, 'foe_id' => 3, 'drop_rate' => 0.25], // Barroth Shell
            ['material_id' => 10, 'foe_id' => 3, 'drop_rate' => 0.10], // Iron Ore

            // Royal Ludroth (Piscine Wyvern)
            ['material_id' => 5, 'foe_id' => 4, 'drop_rate' => 0.35], // Jagras Scale
            ['material_id' => 16, 'foe_id' => 4, 'drop_rate' => 0.20], // Jagras Hide
            ['material_id' => 14, 'foe_id' => 4, 'drop_rate' => 0.10], // Monster Broth

            // Tobi-Kadachi (Fanged Wyvern)
            ['material_id' => 13, 'foe_id' => 5, 'drop_rate' => 0.30], // Monster Fluid
            ['material_id' => 19, 'foe_id' => 5, 'drop_rate' => 0.15], // Rathalos Fang
            ['material_id' => 20, 'foe_id' => 5, 'drop_rate' => 0.10], // Monster Essence

            // Arzuros (Fanged Beast)
            ['material_id' => 17, 'foe_id' => 6, 'drop_rate' => 0.35], // Anjanath Pelt
            ['material_id' => 8, 'foe_id' => 6, 'drop_rate' => 0.20], // Great Jagras Claw
            ['material_id' => 1, 'foe_id' => 6, 'drop_rate' => 0.10], // Monster Bone S

            // Kushala Daora (Elder Dragon)
            ['material_id' => 21, 'foe_id' => 7, 'drop_rate' => 0.40], // Rathalos Shell
            ['material_id' => 20, 'foe_id' => 7, 'drop_rate' => 0.25], // Monster Essence
            ['material_id' => 12, 'foe_id' => 7, 'drop_rate' => 0.10], // Dragonite Ore

            // Aptonoth (Herbivore)
            ['material_id' => 16, 'foe_id' => 8, 'drop_rate' => 0.60], // Jagras Hide
            ['material_id' => 1, 'foe_id' => 8, 'drop_rate' => 0.30], // Monster Bone S

            // Raphinos (Neopteron)
            ['material_id' => 13, 'foe_id' => 9, 'drop_rate' => 0.50], // Monster Fluid
            ['material_id' => 14, 'foe_id' => 9, 'drop_rate' => 0.20], // Monster Broth

            // Zamtrios (Amphibian)
            ['material_id' => 18, 'foe_id' => 10, 'drop_rate' => 0.35], // Rathalos Shell
            ['material_id' => 27, 'foe_id' => 10, 'drop_rate' => 0.15], // Diablos Shell

            // Mizutsune (Leviathan)
            ['material_id' => 14, 'foe_id' => 11, 'drop_rate' => 0.40], // Monster Broth
            ['material_id' => 20, 'foe_id' => 11, 'drop_rate' => 0.20], // Monster Essence

            // Nerscylla (Temnoceran)
            ['material_id' => 9, 'foe_id' => 12, 'drop_rate' => 0.45], // Kulu-Ya-Ku Hide
            ['material_id' => 23, 'foe_id' => 12, 'drop_rate' => 0.15], // Barroth Shell

            // Najarala (Snake Wyvern)
            ['material_id' => 19, 'foe_id' => 13, 'drop_rate' => 0.30], // Rathalos Fang
            ['material_id' => 21, 'foe_id' => 13, 'drop_rate' => 0.20], // Rathalos Shell

            // Hermitaur (Carapaceon)
            ['material_id' => 23, 'foe_id' => 14, 'drop_rate' => 0.50], // Barroth Shell
            ['material_id' => 22, 'foe_id' => 14, 'drop_rate' => 0.20], // Rathalos Shell
        ]);
    }
}