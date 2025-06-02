<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('foes')->insert([
            // 1. Bird Wyvern
            ['foe_name' => 'Great Jaggi', 'foe_type' => 1, 'foe_size' => 'Big', 'foe_description' => 'A cunning Bird Wyvern that leads a pack.', 'foe_icon' => 'monster_icon/great_jaggi.png', 'foe_image' => 'monster_image/great_jaggi.png'],
            // 2. Flying Wyvern
            ['foe_name' => 'Rathalos', 'foe_type' => 2, 'foe_size' => 'Big', 'foe_description' => 'The King of the Skies, a classic Flying Wyvern.', 'foe_icon' => 'monster_icon/rathalos.png', 'foe_image' => 'monster_image/rathalos.png'],
            // 3. Brute Wyvern
            ['foe_name' => 'Barroth', 'foe_type' => 3, 'foe_size' => 'Big', 'foe_description' => 'A Brute Wyvern that loves mud.', 'foe_icon' => 'monster_icon/barroth.png', 'foe_image' => 'monster_image/barroth.png'],
            // 4. Piscine Wyvern
            ['foe_name' => 'Royal Ludroth', 'foe_type' => 4, 'foe_size' => 'Big', 'foe_description' => 'A Piscine Wyvern with a sponge-like mane.', 'foe_icon' => 'monster_icon/royal_ludroth.png', 'foe_image' => 'monster_image/royal_ludroth.png'],
            // 5. Fanged Wyvern
            ['foe_name' => 'Tobi-Kadachi', 'foe_type' => 5, 'foe_size' => 'Big', 'foe_description' => 'A nimble Fanged Wyvern with electric attacks.', 'foe_icon' => 'monster_icon/tobi_kadachi.png', 'foe_image' => 'monster_image/tobi_kadachi.png'],
            // 6. Fanged Beast
            ['foe_name' => 'Arzuros', 'foe_type' => 6, 'foe_size' => 'Big', 'foe_description' => 'A bear-like Fanged Beast.', 'foe_icon' => 'monster_icon/arzuros.png', 'foe_image' => 'monster_image/arzuros.png'],
            // 7. Elder Dragon
            ['foe_name' => 'Kushala Daora', 'foe_type' => 7, 'foe_size' => 'Big', 'foe_description' => 'A steel dragon that commands the wind.', 'foe_icon' => 'monster_icon/kushala_daora.png', 'foe_image' => 'monster_image/kushala_daora.png'],
            // 8. Herbivore
            ['foe_name' => 'Aptonoth', 'foe_type' => 8, 'foe_size' => 'Small', 'foe_description' => 'A docile herbivorous monster.', 'foe_icon' => 'monster_icon/aptonoth.png', 'foe_image' => 'monster_image/aptonoth.png'],
            // 9. Neopteron
            ['foe_name' => 'Altaroth', 'foe_type' => 9, 'foe_size'=>'Small', 'foe_description'=>'A small insectoid monster that collects mushrooms.', 'foe_icon'=>'monster_icon/altaroth.png', 'foe_image'=>'monster_image/altaroth.png'],
            // 10. Amphibian
            ['foe_name' => 'Zamtrios', 'foe_type' => 10, 'foe_size'=>'Big', 'foe_description'=>'A shark-like amphibian that can inflate itself.', 'foe_icon'=>'monster_icon/zamtrios.png', 'foe_image'=>'monster_image/zamtrios.png'],
            // 11. Leviathan
            ['foe_name' => 'Mizutsune', 'foe_type' => 11, 'foe_size' => 'Big', 'foe_description' => 'A graceful Leviathan that manipulates bubbles.', 'foe_icon' => 'monster_icon/mizutsune.png', 'foe_image' => 'monster_image/mizutsune.png'],
            // 12. Temnoceran
            ['foe_name' => 'Nerscylla', 'foe_type' => 12, 'foe_size' => 'Big', 'foe_description' => 'A spider-like Temnoceran.', 'foe_icon' => 'monster_icon/nerscylla.png', 'foe_image' => 'monster_image/nerscylla.png'],
            // 13. Snake Wyvern
            ['foe_name' => 'Najarala', 'foe_type' => 13, 'foe_size'=>'Big', 'foe_description'=>'A large Snake Wyvern that constricts its prey.', 'foe_icon'=>'monster_icon/najarala.png', 'foe_image'=>'monster_image/najarala.png'],
            // 14. Carapaceon
            ['foe_name' => 'Daimyo Hermitaur', 'foe_type' => 14, 'foe_size'=>'Big', 'foe_description'=>'A crab-like Carapaceon with a tough shell.', 'foe_icon'=>'monster_icon/daimyo_hermitaur.png', 'foe_image'=>'monster_image/daimyo_hermitaur.png'],
        ]);
    }
}
