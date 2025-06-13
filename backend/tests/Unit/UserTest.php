<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Equipment;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'user_name' => 'testuser',
            'user_email' => 'test@example.com',
            'user_password' => bcrypt('password'),
            'user_type' => 'user'
        ]);

        $this->assertDatabaseHas('users', [
            'user_name' => 'testuser',
            'user_email' => 'test@example.com',
        ]);
    }

    public function test_user_has_equipment_relationship(): void
    {
        // Use seeded data
        $user = User::where('user_email', 'bob@example.com')->first();
        $equipment = Equipment::first(); // Get first seeded equipment
        
        $user->equipment()->attach($equipment->equipment_id);
        
        $this->assertTrue($user->equipment->contains($equipment));
    }

    public function test_user_has_materials_relationship(): void
    {
        // Use seeded data - Bob already has materials, so check existing relationship
        $user = User::where('user_email', 'bob@example.com')->first();
        
        // Bob (user_id 2) already has materials from seeder
        $this->assertTrue($user->materials->count() > 0);
        
        // Check the first material relationship
        $firstMaterial = $user->materials->first();
        $this->assertNotNull($firstMaterial->pivot->quantity);
        
        // Test adding a new material that Bob doesn't have
        $newMaterial = Material::whereNotIn('material_id', $user->materials->pluck('material_id'))->first();
        if ($newMaterial) {
            $user->materials()->attach($newMaterial->material_id, ['quantity' => 5]);
            $user->refresh();
            $this->assertTrue($user->materials->contains($newMaterial));
        }
    }

    public function test_user_password_is_hidden(): void
    {
        $user = User::where('user_email', 'bob@example.com')->first();
        
        $userArray = $user->toArray();
        
        $this->assertArrayNotHasKey('user_password', $userArray);
    }
}