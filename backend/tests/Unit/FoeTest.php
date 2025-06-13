<?php

namespace Tests\Unit;

use App\Models\Foe;
use App\Models\Material;
use App\Models\FoeType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_foe_can_be_created(): void
    {
        $foe = Foe::create([
            'foe_name' => 'Test Monster',
            'foe_type' => 1, // Use existing foe type from seeder
            'foe_size' => 'Big',
            'foe_description' => 'A test monster'
        ]);

        $this->assertDatabaseHas('foes', [
            'foe_name' => 'Test Monster',
            'foe_size' => 'Big',
        ]);
    }

    public function test_foe_has_materials_relationship(): void
    {
        // Use seeded data - Great Jaggi already has materials from seeder
        $foe = Foe::where('foe_name', 'Great Jaggi')->first();

        // Great Jaggi already has materials from seeder
        $this->assertTrue($foe->materials->count() > 0);

        // Check the first material relationship
        $firstMaterial = $foe->materials->first();
        $this->assertNotNull($firstMaterial->pivot->drop_rate);

        // Test adding a new material that Great Jaggi doesn't have
        $newMaterial = Material::whereNotIn('material_id', $foe->materials->pluck('material_id'))->first();
        if ($newMaterial) {
            $foe->materials()->attach($newMaterial->material_id, ['drop_rate' => 0.25]);
            $foe->refresh();
            $this->assertTrue($foe->materials->contains($newMaterial));
        }
    }

    public function test_foe_belongs_to_foe_type(): void
    {
        // Use seeded data
        $foe = Foe::where('foe_name', 'Great Jaggi')->first();

        $this->assertInstanceOf(FoeType::class, $foe->type);
        $this->assertNotNull($foe->type);
    }
}
