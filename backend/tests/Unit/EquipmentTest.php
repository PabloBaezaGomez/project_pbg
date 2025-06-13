<?php

namespace Tests\Unit;

use App\Models\Equipment;
use App\Models\Material;
use App\Models\EquipmentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_equipment_can_be_created(): void
    {
        Equipment::create([
            'equipment_name' => 'Test Weapon',
            'equipment_type' => 1, // Use existing equipment type from seeder
            'equipment_stat' => 100,
            'equipment_description' => 'A test weapon'
        ]);

        $this->assertDatabaseHas('equipment', [
            'equipment_name' => 'Test Weapon',
            'equipment_stat' => 100,
        ]);
    }

    public function test_equipment_has_materials_relationship(): void
    {
        // Use seeded data - find first equipment that has materials from seeder
        $equipment = Equipment::whereHas('materials')->first();

        if ($equipment) {
            // Equipment already has materials from seeder
            $this->assertTrue($equipment->materials->count() > 0);

            // Check the first material relationship
            $firstMaterial = $equipment->materials->first();
            $this->assertNotNull($firstMaterial->pivot->required_quantity);

            // Test adding a new material that this equipment doesn't have
            $newMaterial = Material::whereNotIn('material_id', $equipment->materials->pluck('material_id'))->first();
            if ($newMaterial) {
                $equipment->materials()->attach($newMaterial->material_id, ['required_quantity' => 5]);
                $equipment->refresh();
                $this->assertTrue($equipment->materials->contains($newMaterial));
            }
        } else {
            // If no equipment with materials exists, create one and test the relationship
            $equipment = Equipment::create([
                'equipment_name' => 'Test Equipment',
                'equipment_type' => 1,
                'equipment_stat' => 50,
                'equipment_description' => 'Test equipment for materials'
            ]);

            $material = Material::first();
            $equipment->materials()->attach($material->material_id, ['required_quantity' => 3]);
            $equipment->refresh();

            $this->assertTrue($equipment->materials->contains($material));
            $this->assertEquals(3, $equipment->materials->first()->pivot->required_quantity);
        }
    }

    public function test_equipment_belongs_to_equipment_type(): void
    {
        // Use seeded data or create equipment with type
        $equipment = Equipment::first();

        if (!$equipment) {
            $equipment = Equipment::create([
                'equipment_name' => 'Test Equipment',
                'equipment_type' => 1,
                'equipment_stat' => 50,
                'equipment_description' => 'Test equipment'
            ]);
        }

        $this->assertInstanceOf(EquipmentType::class, $equipment->type);
        $this->assertNotNull($equipment->type);
    }

    public function test_equipment_has_users_relationship(): void
    {
        // Test the many-to-many relationship with users
        $equipment = Equipment::first();

        if (!$equipment) {
            $equipment = Equipment::create([
                'equipment_name' => 'Test Equipment',
                'equipment_type' => 1,
                'equipment_stat' => 50,
                'equipment_description' => 'Test equipment'
            ]);
        }

        // Test that the users relationship exists and returns a collection
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $equipment->users);
    }
}
