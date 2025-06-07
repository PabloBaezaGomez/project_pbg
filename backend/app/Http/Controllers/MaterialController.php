<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialType;

class MaterialController extends Controller
{
    /**
     * Display a listing of all materials.
     * This method retrieves all materials along with their types and returns them in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $materials = Material::with('type')->get()->map(function ($material) {
            return [
                'material_id' => $material->material_id,
                'material_name' => $material->material_name,
                'material_rarity' => $material->material_rarity,
                'type' => [
                    'id' => $material->type->material_type_id,
                    'name' => $material->type->material_type_name,
                    'icon' => $material->type->material_type_icon
                ]
            ];
        });

        return response()->json($materials);
    }

    /**
     * Get materials for the authenticated user.
     * This method retrieves the materials associated with the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userMaterials()
    {
        $user = Auth::user();
        $materials = $user->materials;
        return response()->json($materials);
    }

    /**
     * Display a specific material by ID.
     * This method retrieves a material along with its type, equipment, and foes, returning them in a JSON response.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Material $material)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'material' => [
                    'id' => $material->material_id,
                    'name' => $material->material_name,
                    'description' => $material->material_description,
                    'rarity' => $material->material_rarity,
                    'type' => [
                        'id' => $material->type->material_type_id,
                        'name' => $material->type->material_type_name,
                        'icon' => $material->type->material_type_icon
                    ],
                    'equipment' => $material->equipment()->with('type')->get()->map(function ($equipment) {
                        return [
                            'id' => $equipment->equipment_id,
                            'name' => $equipment->equipment_name,
                            'type' => [
                                'id' => $equipment->type->equipment_type_id,
                                'name' => $equipment->type->equipment_type_name,
                                'icon' => $equipment->type->equipment_type_icon
                            ],
                            'required_quantity' => $equipment->pivot->required_quantity
                        ];
                    }),
                    'foes' => $material->foes()->with('type')->get()->map(function ($foe) {
                        return [
                            'id' => $foe->foe_id,
                            'name' => $foe->foe_name,
                            'icon' => $foe->foe_icon,

                            'drop_rate' => $foe->pivot->drop_rate
                        ];
                    })
                ]
            ]
        ]);
    }

    /**
     * Store a new material.
     * This method allows the creation of new materials by validating the request data,
     * handling foes and their drop rates, and returning a JSON response indicating success or failure.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'material_name' => 'required|string|max:255|unique:materials,material_name',
            'material_description' => 'required|string',
            'material_rarity' => 'required|integer|min:1|max:9',
            'material_type' => 'required|exists:material_types,material_type_id',
            'foes' => 'array',
            'foes.*.foe_id' => 'required|exists:foes,foe_id',
            'foes.*.drop_rate' => 'required|numeric|min:0|max:100'
        ]);

        try {
            // Create the material
            $material = Material::create([
                'material_name' => $validatedData['material_name'],
                'material_description' => $validatedData['material_description'],
                'material_rarity' => $validatedData['material_rarity'],
                'material_type' => $validatedData['material_type']
            ]);

            // Attach foes with their drop rates if provided
            if (isset($validatedData['foes'])) {
                $foeData = collect($validatedData['foes'])->mapWithKeys(function ($item) {
                    return [$item['foe_id'] => ['drop_rate' => $item['drop_rate']]];
                })->toArray();

                $material->foes()->attach($foeData);
            }

            // Load the relationships and return the response
            $material->load(['foes', 'type']);

            return response()->json([
                'message' => 'Material created successfully',
                'material' => $material
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating material',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all material types.
     * This method retrieves all material types and returns them in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypes()
    {
        $types = MaterialType::all()->map(function ($type) {
            return [
                'material_type_id' => $type->material_type_id,
                'material_type_name' => $type->material_type_name,
                'material_type_icon' => $type->material_type_icon
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }
}
