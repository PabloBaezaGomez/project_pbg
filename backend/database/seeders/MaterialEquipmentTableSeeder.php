<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialEquipmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('material_equipment')->insert([
            // Great Sword
            ['material_id' => 1, 'equipment_id' => 1, 'required_quantity' => 5],   // Monster Bone S
            ['material_id' => 4, 'equipment_id' => 1, 'required_quantity' => 2],   // Rathalos Scale
            ['material_id' => 10, 'equipment_id' => 1, 'required_quantity' => 1],  // Iron Ore

            // Wyvern Jawblade
            ['material_id' => 2, 'equipment_id' => 2, 'required_quantity' => 8],   // Monster Bone M
            ['material_id' => 5, 'equipment_id' => 2, 'required_quantity' => 3],   // Jagras Scale
            ['material_id' => 11, 'equipment_id' => 2, 'required_quantity' => 2],  // Machalite Ore

            // Iron Katana
            ['material_id' => 3, 'equipment_id' => 3, 'required_quantity' => 6],   // Monster Bone L
            ['material_id' => 6, 'equipment_id' => 3, 'required_quantity' => 4],   // Barroth Claw
            ['material_id' => 12, 'equipment_id' => 3, 'required_quantity' => 2],  // Dragonite Ore

            // Hidden Saber
            ['material_id' => 7, 'equipment_id' => 4, 'required_quantity' => 7],   // Rathian Claw
            ['material_id' => 13, 'equipment_id' => 4, 'required_quantity' => 2],  // Monster Fluid
            ['material_id' => 19, 'equipment_id' => 4, 'required_quantity' => 1],  // Rathalos Fang

            // Hunter's Knife
            ['material_id' => 8, 'equipment_id' => 5, 'required_quantity' => 3],   // Great Jagras Claw
            ['material_id' => 16, 'equipment_id' => 5, 'required_quantity' => 2],  // Jagras Hide
            ['material_id' => 10, 'equipment_id' => 5, 'required_quantity' => 1],  // Iron Ore

            // Carapace Slicer
            ['material_id' => 17, 'equipment_id' => 6, 'required_quantity' => 4],  // Anjanath Pelt
            ['material_id' => 22, 'equipment_id' => 6, 'required_quantity' => 2],  // Rathalos Shell
            ['material_id' => 11, 'equipment_id' => 6, 'required_quantity' => 2],  // Machalite Ore

            // Dual Daggers
            ['material_id' => 23, 'equipment_id' => 7, 'required_quantity' => 5],  // Barroth Shell
            ['material_id' => 28, 'equipment_id' => 7, 'required_quantity' => 2],  // Diablos Shell
            ['material_id' => 12, 'equipment_id' => 7, 'required_quantity' => 1],  // Dragonite Ore

            // Blazing Twinblades
            ['material_id' => 14, 'equipment_id' => 8, 'required_quantity' => 6],  // Monster Broth
            ['material_id' => 20, 'equipment_id' => 8, 'required_quantity' => 2],  // Monster Essence
            ['material_id' => 13, 'equipment_id' => 8, 'required_quantity' => 1],  // Monster Fluid

            // Iron Hammer
            ['material_id' => 1, 'equipment_id' => 9, 'required_quantity' => 8],   // Monster Bone S
            ['material_id' => 6, 'equipment_id' => 9, 'required_quantity' => 3],   // Barroth Claw
            ['material_id' => 10, 'equipment_id' => 9, 'required_quantity' => 2],  // Iron Ore

            // Bone Bludgeon
            ['material_id' => 2, 'equipment_id' => 10, 'required_quantity' => 10], // Monster Bone M
            ['material_id' => 7, 'equipment_id' => 10, 'required_quantity' => 2],  // Rathian Claw
            ['material_id' => 11, 'equipment_id' => 10, 'required_quantity' => 2], // Machalite Ore

            // Metal Bagpipe
            ['material_id' => 3, 'equipment_id' => 11, 'required_quantity' => 7],  // Monster Bone L
            ['material_id' => 8, 'equipment_id' => 11, 'required_quantity' => 2],  // Great Jagras Claw
            ['material_id' => 12, 'equipment_id' => 11, 'required_quantity' => 1], // Dragonite Ore

            // Great Bagpipe
            ['material_id' => 4, 'equipment_id' => 12, 'required_quantity' => 9],  // Rathalos Scale
            ['material_id' => 13, 'equipment_id' => 12, 'required_quantity' => 2], // Monster Fluid
            ['material_id' => 19, 'equipment_id' => 12, 'required_quantity' => 1], // Rathalos Fang

            // Iron Lance
            ['material_id' => 5, 'equipment_id' => 13, 'required_quantity' => 6],  // Jagras Scale
            ['material_id' => 14, 'equipment_id' => 13, 'required_quantity' => 2], // Monster Broth
            ['material_id' => 10, 'equipment_id' => 13, 'required_quantity' => 1], // Iron Ore

            // Knight Lance
            ['material_id' => 6, 'equipment_id' => 14, 'required_quantity' => 8],  // Barroth Claw
            ['material_id' => 15, 'equipment_id' => 14, 'required_quantity' => 2], // Monster Essence
            ['material_id' => 11, 'equipment_id' => 14, 'required_quantity' => 2], // Machalite Ore

            // Iron Gunlance
            ['material_id' => 7, 'equipment_id' => 15, 'required_quantity' => 5],  // Rathian Claw
            ['material_id' => 16, 'equipment_id' => 15, 'required_quantity' => 2], // Jagras Hide
            ['material_id' => 12, 'equipment_id' => 15, 'required_quantity' => 1], // Dragonite Ore

            // Chrome Gunlance
            ['material_id' => 8, 'equipment_id' => 16, 'required_quantity' => 7],  // Great Jagras Claw
            ['material_id' => 17, 'equipment_id' => 16, 'required_quantity' => 2], // Anjanath Pelt
            ['material_id' => 13, 'equipment_id' => 16, 'required_quantity' => 1], // Monster Fluid

            // Switch Axe
            ['material_id' => 9, 'equipment_id' => 17, 'required_quantity' => 6],  // Kulu-Ya-Ku Hide
            ['material_id' => 18, 'equipment_id' => 17, 'required_quantity' => 2], // Rathalos Shell
            ['material_id' => 14, 'equipment_id' => 17, 'required_quantity' => 1], // Monster Broth

            // Power Axe
            ['material_id' => 10, 'equipment_id' => 18, 'required_quantity' => 8], // Iron Ore
            ['material_id' => 19, 'equipment_id' => 18, 'required_quantity' => 2], // Rathalos Fang
            ['material_id' => 15, 'equipment_id' => 18, 'required_quantity' => 1], // Monster Essence

            // Charge Blade
            ['material_id' => 11, 'equipment_id' => 19, 'required_quantity' => 7], // Machalite Ore
            ['material_id' => 20, 'equipment_id' => 19, 'required_quantity' => 2], // Monster Essence
            ['material_id' => 16, 'equipment_id' => 19, 'required_quantity' => 1], // Jagras Hide

            // Impact Charge Blade
            ['material_id' => 12, 'equipment_id' => 20, 'required_quantity' => 9], // Dragonite Ore
            ['material_id' => 21, 'equipment_id' => 20, 'required_quantity' => 2], // Rathalos Shell
            ['material_id' => 17, 'equipment_id' => 20, 'required_quantity' => 1], // Anjanath Pelt

            // Insect Glaive
            ['material_id' => 13, 'equipment_id' => 21, 'required_quantity' => 6], // Monster Fluid
            ['material_id' => 22, 'equipment_id' => 21, 'required_quantity' => 2], // Rathalos Shell
            ['material_id' => 18, 'equipment_id' => 21, 'required_quantity' => 1], // Rathalos Shell

            // Empress Cane
            ['material_id' => 14, 'equipment_id' => 22, 'required_quantity' => 8], // Monster Broth
            ['material_id' => 23, 'equipment_id' => 22, 'required_quantity' => 2], // Barroth Shell
            ['material_id' => 19, 'equipment_id' => 22, 'required_quantity' => 1], // Rathalos Fang

            // Hunter's Bow
            ['material_id' => 15, 'equipment_id' => 23, 'required_quantity' => 5], // Monster Essence
            ['material_id' => 24, 'equipment_id' => 23, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 20, 'equipment_id' => 23, 'required_quantity' => 1], // Monster Essence

            // Dragonbone Bow
            ['material_id' => 16, 'equipment_id' => 24, 'required_quantity' => 7], // Jagras Hide
            ['material_id' => 25, 'equipment_id' => 24, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 21, 'equipment_id' => 24, 'required_quantity' => 1], // Rathalos Shell

            // Light Bowgun
            ['material_id' => 17, 'equipment_id' => 25, 'required_quantity' => 6], // Anjanath Pelt
            ['material_id' => 26, 'equipment_id' => 25, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 22, 'equipment_id' => 25, 'required_quantity' => 1], // Rathalos Shell

            // Blizzard Cannon
            ['material_id' => 18, 'equipment_id' => 26, 'required_quantity' => 8], // Rathalos Shell
            ['material_id' => 27, 'equipment_id' => 26, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 23, 'equipment_id' => 26, 'required_quantity' => 1], // Barroth Shell

            // Heavy Bowgun
            ['material_id' => 19, 'equipment_id' => 27, 'required_quantity' => 7], // Rathalos Fang
            ['material_id' => 28, 'equipment_id' => 27, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 24, 'equipment_id' => 27, 'required_quantity' => 1], // Diablos Shell

            // Destruction Cannon
            ['material_id' => 20, 'equipment_id' => 28, 'required_quantity' => 9], // Monster Essence
            ['material_id' => 25, 'equipment_id' => 28, 'required_quantity' => 2], // Diablos Shell
            ['material_id' => 21, 'equipment_id' => 28, 'required_quantity' => 1], // Rathalos Shell

            // --- ARMOR ---

            // Leather Headgear
            ['material_id' => 1, 'equipment_id' => 29, 'required_quantity' => 2],  // Monster Bone S
            ['material_id' => 16, 'equipment_id' => 29, 'required_quantity' => 1], // Jagras Hide

            // Rathalos Helm
            ['material_id' => 4, 'equipment_id' => 30, 'required_quantity' => 3],  // Rathalos Scale
            ['material_id' => 19, 'equipment_id' => 30, 'required_quantity' => 1], // Rathalos Fang

            // Leather Mail
            ['material_id' => 1, 'equipment_id' => 31, 'required_quantity' => 3],  // Monster Bone S
            ['material_id' => 16, 'equipment_id' => 31, 'required_quantity' => 2], // Jagras Hide

            // Rathalos Mail
            ['material_id' => 4, 'equipment_id' => 32, 'required_quantity' => 4],  // Rathalos Scale
            ['material_id' => 22, 'equipment_id' => 32, 'required_quantity' => 2], // Rathalos Shell

            // Leather Gloves
            ['material_id' => 1, 'equipment_id' => 33, 'required_quantity' => 2],  // Monster Bone S
            ['material_id' => 16, 'equipment_id' => 33, 'required_quantity' => 1], // Jagras Hide

            // Rathalos Vambraces
            ['material_id' => 4, 'equipment_id' => 34, 'required_quantity' => 2],  // Rathalos Scale
            ['material_id' => 19, 'equipment_id' => 34, 'required_quantity' => 1], // Rathalos Fang

            // Leather Belt
            ['material_id' => 1, 'equipment_id' => 35, 'required_quantity' => 2],  // Monster Bone S
            ['material_id' => 16, 'equipment_id' => 35, 'required_quantity' => 1], // Jagras Hide

            // Rathalos Coil
            ['material_id' => 4, 'equipment_id' => 36, 'required_quantity' => 3],  // Rathalos Scale
            ['material_id' => 22, 'equipment_id' => 36, 'required_quantity' => 1], // Rathalos Shell

            // Leather Pants
            ['material_id' => 1, 'equipment_id' => 37, 'required_quantity' => 2],  // Monster Bone S
            ['material_id' => 16, 'equipment_id' => 37, 'required_quantity' => 1], // Jagras Hide

            // Rathalos Greaves
            ['material_id' => 4, 'equipment_id' => 38, 'required_quantity' => 3],  // Rathalos Scale
            ['material_id' => 22, 'equipment_id' => 38, 'required_quantity' => 1], // Rathalos Shell
        ]);
    }
}