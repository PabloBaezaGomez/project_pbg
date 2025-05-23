<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialUser;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('type')->get()->map(function ($equipment) {
            return [
                'equipment_id' => $equipment->equipment_id,
                'equipment_name' => $equipment->equipment_name,
                'equipment_description' => $equipment->equipment_description,
                'equipment_image' => $equipment->equipment_image,
                'equipment_stat' => $equipment->equipment_stat,
                'type' => [
                    'id' => $equipment->type->equipment_type_id,
                    'name' => $equipment->type->equipment_type_name,
                    'icon' => $equipment->type->equipment_type_icon
                ]
            ];
        });

        return response()->json($equipment);
    }

    public function userEquipment()
    {
        $user = Auth::user();
        $equipment = $user->equipment;
        return response()->json($equipment);
    }

    public function getMaterials(Equipment $equipment)
    {
        return response()->json([
            'success' => true,
            'data' => $equipment->materials()->with('type')->get()
        ]);
    }

    public function show(Equipment $equipment)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'equipment' => [
                    'equipment_id' => $equipment->equipment_id,
                    'equipment_name' => $equipment->equipment_name,
                    'equipment_description' => $equipment->equipment_description,
                    'equipment_image' => $equipment->equipment_image,
                    'equipment_stat' => $equipment->equipment_stat,
                    'type' => [
                        'id' => $equipment->type->equipment_type_id,
                        'name' => $equipment->type->equipment_type_name,
                        'icon' => $equipment->type->equipment_type_icon
                    ],
                    'materials' => $equipment->materials()->with('type')->get()->map(function ($material) {
                        return [
                            'id' => $material->material_id,
                            'name' => $material->material_name,
                            'type' => [
                                'id' => $material->type->material_type_id,
                                'name' => $material->type->material_type_name,
                                'icon' => $material->type->material_type_icon
                            ],
                            'required_quantity' => $material->pivot->required_quantity
                        ];
                    })
                ]
            ]
        ]);
    }

    public function craftEquipment(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,equipment_id'
        ]);

        $userId = Auth::id();
        $equipment = Equipment::with('materials')->findOrFail($request->equipment_id);

        // Check if user already has this equipment
        if ($equipment->users()->where('equipment_user.user_id', $userId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You already have this equipment'
            ], 400);
        }

        // Get all required materials and user's current materials
        $requiredMaterials = $equipment->materials;
        $userMaterials = MaterialUser::where('user_id', $userId)
            ->whereIn('material_id', $requiredMaterials->pluck('material_id'))
            ->get()
            ->keyBy('material_id');

        // Check if user has all required materials
        $missingMaterials = [];
        foreach ($requiredMaterials as $material) {
            $required = $material->pivot->required_quantity;
            $userHas = isset($userMaterials[$material->material_id])
                ? $userMaterials[$material->material_id]->quantity
                : 0;

            if ($userHas < $required) {
                $missingMaterials[] = [
                    'material_id' => $material->material_id,
                    'material_name' => $material->material_name,
                    'required' => $required,
                    'has' => $userHas,
                    'missing' => $required - $userHas
                ];
            }
        }

        if (!empty($missingMaterials)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient materials',
                'missing_materials' => $missingMaterials
            ], 400);
        }

        // If we have all materials, start crafting
        DB::beginTransaction();
        try {
            // Deduct materials using specific updates for each material-user combination
            foreach ($requiredMaterials as $material) {
                $affected = DB::table('material_user')
                    ->where('user_id', $userId)
                    ->where('material_id', $material->material_id)
                    ->decrement('quantity', $material->pivot->required_quantity);

                if ($affected === 0) {
                    throw new \Exception('Failed to update material quantity');
                }
            }

            // Add equipment to user
            $equipment->users()->attach($userId);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Equipment crafted successfully',
                'equipment' => $equipment
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error crafting equipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_name' => 'required|string|max:255|unique:equipment',
            'equipment_type' => 'required|exists:equipment_types,equipment_type_id',
            'equipment_description' => 'required|string',
            'equipment_image' => 'required|string',
            'equipment_stat' => 'required|integer',
            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            $equipment = Equipment::create([
                'equipment_name' => $validated['equipment_name'],
                'equipment_type' => $validated['equipment_type'],
                'equipment_description' => $validated['equipment_description'],
                'equipment_image' => $validated['equipment_image'],
                'equipment_stat' => $validated['equipment_stat']
            ]);

            // Attach materials with their quantities, using required_quantity instead of quantity
            foreach ($validated['materials'] as $material) {
                $equipment->materials()->attach($material['material_id'], [
                    'required_quantity' => $material['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Equipment created successfully',
                'data' => [
                    'equipment' => $equipment,
                    'materials' => $equipment->materials
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating equipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
