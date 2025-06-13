<?php

namespace Tests\Unit;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\Foe;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_material_can_be_created(): void
    {
        $material = Material::create([
            'material_name' => 'Test Material',
            'material_description' => 'A test material',
            'material_rarity' => 5,
            'material_type' => 1 // Use existing material type from seeder
        ]);

        $this->assertDatabaseHas('materials', [
            'material_name' => 'Test Material',
            'material_rarity' => 5,
        ]);
    }

    public function test_material_belongs_to_material_type(): void
    {
        $material = Material::first();

        if ($material) {
            $this->assertInstanceOf(MaterialType::class, $material->type);
            $this->assertNotNull($material->type->material_type_name);
        } else {
            $this->markTestSkipped('No materials seeded');
        }
    }

    public function test_material_has_foes_relationship(): void
    {
        // Use seeded data - find a material that has foes
        $material = Material::whereHas('foes')->first();

        if ($material) {
            $this->assertTrue($material->foes->count() > 0);

            // Check the first foe relationship
            $firstFoe = $material->foes->first();
            $this->assertNotNull($firstFoe->pivot->drop_rate);

            // Test adding a new foe that this material doesn't have
            $newFoe = Foe::whereNotIn('foe_id', $material->foes->pluck('foe_id'))->first();
            if ($newFoe) {
                $material->foes()->attach($newFoe->foe_id, ['drop_rate' => 25]);
                $material->refresh();
                $this->assertTrue($material->foes->contains($newFoe));
            }
        } else {
            // If no material with foes exists, create one and test the relationship
            $material = Material::create([
                'material_name' => 'Test Material for Foes',
                'material_description' => 'Test material for foe relationship',
                'material_rarity' => 3,
                'material_type' => 1
            ]);

            $foe = Foe::first();
            if ($foe) {
                $material->foes()->attach($foe->foe_id, ['drop_rate' => 30]);
                $material->refresh();
                $this->assertTrue($material->foes->contains($foe));
            } else {
                $this->markTestSkipped('No foes seeded');
            }
        }
    }

    public function test_material_has_equipment_relationship(): void
    {
        // Use seeded data - find a material that has equipment
        $material = Material::whereHas('equipment')->first();

        if ($material) {
            $this->assertTrue($material->equipment->count() > 0);

            // Check the first equipment relationship
            $firstEquipment = $material->equipment->first();
            $this->assertNotNull($firstEquipment->pivot->required_quantity);

            // Test adding a new equipment that this material doesn't have
            $newEquipment = Equipment::whereNotIn('equipment_id', $material->equipment->pluck('equipment_id'))->first();
            if ($newEquipment) {
                $material->equipment()->attach($newEquipment->equipment_id, ['required_quantity' => 3]);
                $material->refresh();
                $this->assertTrue($material->equipment->contains($newEquipment));
            }
        } else {
            // If no material with equipment exists, create one and test the relationship
            $material = Material::create([
                'material_name' => 'Test Material for Equipment',
                'material_description' => 'Test material for equipment relationship',
                'material_rarity' => 4,
                'material_type' => 1
            ]);

            $equipment = Equipment::first();
            if ($equipment) {
                $material->equipment()->attach($equipment->equipment_id, ['required_quantity' => 2]);
                $material->refresh();
                $this->assertTrue($material->equipment->contains($equipment));
            } else {
                $this->markTestSkipped('No equipment seeded');
            }
        }
    }
}
