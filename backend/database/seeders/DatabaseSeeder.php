<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MaterialTypesTableSeeder::class,
            MaterialsTableSeeder::class,
            UsersTableSeeder::class,
            FoeTypesTableSeeder::class,
            FoesTableSeeder::class,
            EquipmentTypesTableSeeder::class,
            EquipmentTableSeeder::class,
            MaterialUserTableSeeder::class,
            MaterialFoeTableSeeder::class,
            EquipmentUserTableSeeder::class,
            MaterialEquipmentTableSeeder::class,
        ]);
    }
}
