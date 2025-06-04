<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialUser;

class EquipmentController extends Controller
{
    /**
     * This method retrieves all equipment along with their types and returns them in a JSON response.
     * It maps the equipment data to include only necessary fields and their associated type information.
     * Returns also the equipment type with its path, to show it to the user.
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $equipment = Equipment::with('type')->get()->map(function ($equipment) {
            return [
                'equipment_id' => $equipment->equipment_id,
                'equipment_name' => $equipment->equipment_name,
                'type' => [
                    'name' => $equipment->type->equipment_type_name,
                    'icon' => $equipment->type->equipment_type_icon
                ]
            ];
        });

        return response()->json($equipment);
    }

    /**
     * This method retrieves the equipment associated with the authenticated user.
     * It returns the equipment data in a JSON response in a similar way to the index function.
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function userEquipment()
    {
        $user = Auth::user();
        $equipment = $user->equipment;
        return response()->json($equipment);
    }

    /**
     * This method retrieves the materials required for a specific equipment item.
     * It returns the materials in a JSON response, including their types.
     * @param \App\Models\Equipment $equipment
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getMaterials(Equipment $equipment)
    {
        return response()->json([
            'success' => true,
            'data' => $equipment->materials()->with('type')->get()
        ]);
    }

    /**
     * This method retrieves detailed information about a specific equipment item.
     * It includes the equipment's ID, name, description, image, stats, type, and required materials.
     * @param \App\Models\Equipment $equipment
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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

    /**
     * This method allows a user to craft equipment if they have the required materials.
     * It checks if the user has all the necessary materials, deducts them from the user's inventory,
     * and then adds the equipment to the user's collection.
     * If the user already has the equipment, it returns an error message.
     * If the user does not have enough materials, it returns a list of missing materials.
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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

    /**
     * This method allows the creation of new equipment by validating the request data,
     * handling file uploads, and storing the equipment along with its required materials.
     * It returns a JSON response indicating success or failure.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_name' => 'required|string|max:255',
            'equipment_type' => 'required|exists:equipment_types,equipment_type_id',
            'equipment_description' => 'required|string',
            'equipment_image' => 'required|file|max:20500',
            'equipment_stat' => 'required|integer',
            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Handle file upload
            $imagePath = null;
            if ($request->hasFile('equipment_image')) {
                $imageFile = $request->file('equipment_image');
                $imageName = 'equipment_' . Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('equipment_images', $imageName, 'public');
            }

            $equipment = Equipment::create([
                'equipment_name' => $validated['equipment_name'],
                'equipment_type' => $validated['equipment_type'],
                'equipment_description' => $validated['equipment_description'],
                'equipment_image' => $imagePath ? '/storage/' . $imagePath : null,
                'equipment_stat' => $validated['equipment_stat']
            ]);

            // Attach materials with their quantities
            foreach ($validated['materials'] as $material) {
                $equipment->materials()->attach($material['material_id'], [
                    'required_quantity' => $material['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Equipment created successfully',
                'data' => [
                    'equipment' => $equipment,
                    'materials' => $equipment->materials
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded file if equipment creation fails
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error creating equipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * This method retrieves all equipment types and returns them in a JSON response.
     * It includes the type's ID, name, and icon.
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getTypes()
    {
        $types = EquipmentType::all();
        
        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }
}
