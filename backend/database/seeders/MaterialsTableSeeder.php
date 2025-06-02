<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('materials')->insert([
            // Bone
            ['material_name' => 'Monster Bone S', 'material_type' => 1, 'material_rarity' => '2', 'material_description' => 'A small bone from a monster.'],
            ['material_name' => 'Monster Bone M', 'material_type' => 1, 'material_rarity' => '3', 'material_description' => 'A medium-sized bone from a monster.'],
            ['material_name' => 'Monster Bone L', 'material_type' => 1, 'material_rarity' => '4', 'material_description' => 'A large bone from a monster.'],

            // Scale
            ['material_name' => 'Rathalos Scale', 'material_type' => 2, 'material_rarity' => '4', 'material_description' => 'A scale from a Rathalos.'],
            ['material_name' => 'Jagras Scale', 'material_type' => 2, 'material_rarity' => '2', 'material_description' => 'A scale from a Jagras.'],
            ['material_name' => 'Anjanath Scale', 'material_type' => 2, 'material_rarity' => '3', 'material_description' => 'A scale from an Anjanath.'],

            // Claw
            ['material_name' => 'Barroth Claw', 'material_type' => 3, 'material_rarity' => '3', 'material_description' => 'A claw from a Barroth.'],
            ['material_name' => 'Rathian Claw', 'material_type' => 3, 'material_rarity' => '4', 'material_description' => 'A claw from a Rathian.'],
            ['material_name' => 'Great Jagras Claw', 'material_type' => 3, 'material_rarity' => '2', 'material_description' => 'A claw from a Great Jagras.'],

            // Hide
            ['material_name' => 'Jagras Hide', 'material_type' => 4, 'material_rarity' => '2', 'material_description' => 'A hide from a Jagras.'],
            ['material_name' => 'Anjanath Pelt', 'material_type' => 4, 'material_rarity' => '4', 'material_description' => 'A pelt from an Anjanath.'],
            ['material_name' => 'Kulu-Ya-Ku Hide', 'material_type' => 4, 'material_rarity' => '3', 'material_description' => 'A hide from a Kulu-Ya-Ku.'],

            // Shell
            ['material_name' => 'Rathalos Shell', 'material_type' => 5, 'material_rarity' => '4', 'material_description' => 'A shell from a Rathalos.'],
            ['material_name' => 'Barroth Shell', 'material_type' => 5, 'material_rarity' => '3', 'material_description' => 'A shell from a Barroth.'],
            ['material_name' => 'Diablos Shell', 'material_type' => 5, 'material_rarity' => '5', 'material_description' => 'A shell from a Diablos.'],

            // Ore
            ['material_name' => 'Iron Ore', 'material_type' => 6, 'material_rarity' => '1', 'material_description' => 'Common ore used for forging.'],
            ['material_name' => 'Machalite Ore', 'material_type' => 6, 'material_rarity' => '3', 'material_description' => 'A valuable ore for weapons and armor.'],
            ['material_name' => 'Dragonite Ore', 'material_type' => 6, 'material_rarity' => '5', 'material_description' => 'A rare ore with mysterious properties.'],

            // Monster Fluid
            ['material_name' => 'Monster Fluid', 'material_type' => 7, 'material_rarity' => '3', 'material_description' => 'A viscous fluid from monsters.'],
            ['material_name' => 'Monster Broth', 'material_type' => 7, 'material_rarity' => '4', 'material_description' => 'A rich broth from powerful monsters.'],
            ['material_name' => 'Monster Essence', 'material_type' => 7, 'material_rarity' => '5', 'material_description' => 'The essence of a monster, very rare.'],

            // Tail
            ['material_name' => 'Rathalos Tail', 'material_type' => 8, 'material_rarity' => '4', 'material_description' => 'A sharp tail from a Rathalos.'],
            ['material_name' => 'Anjanath Tail', 'material_type' => 8, 'material_rarity' => '3', 'material_description' => 'A tail from an Anjanath.'],
            ['material_name' => 'Jagras Tail', 'material_type' => 8, 'material_rarity' => '2', 'material_description' => 'A tail from a Jagras.'],

            // Webbing
            ['material_name' => 'Rathian Webbing', 'material_type' => 9, 'material_rarity' => '4', 'material_description' => 'Webbing from a Rathian.'],
            ['material_name' => 'Paolumu Webbing', 'material_type' => 9, 'material_rarity' => '3', 'material_description' => 'Webbing from a Paolumu.'],
            ['material_name' => 'Legiana Webbing', 'material_type' => 9, 'material_rarity' => '5', 'material_description' => 'Webbing from a Legiana.'],

            // Gem
            ['material_name' => 'Diablos Gem', 'material_type' => 10, 'material_rarity' => '5', 'material_description' => 'A massive Gem from a Diablos.'],
            ['material_name' => 'Barroth Gem', 'material_type' => 10, 'material_rarity' => '3', 'material_description' => 'A Gem from a Barroth.'],
            ['material_name' => 'Radobaan Gem', 'material_type' => 10, 'material_rarity' => '4', 'material_description' => 'A Gem from a Radobaan.'],
        ]);
    }
}