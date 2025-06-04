<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of all materials.
     * This method retrieves all materials and returns them in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Material::all());
    }

    /**
     * Display the authenticated user's information.
     * This method retrieves the user's name and type and returns them in a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'user_name' => $user->user_name,
                'user_type' => $user->user_type
            ]
        ]);
    }

    /**
     * Get materials for authenticated user
     * This method retrieves the materials associated with the currently authenticated user,
     * including their types and quantities.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUserMaterials(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => $user->materials()->with('type')->get()->map(function ($material) {
                return [
                    'material_id' => $material->material_id,
                    'material_name' => $material->material_name,
                    'material_description' => $material->material_description,
                    'material_rarity' => $material->material_rarity,
                    'quantity' => $material->pivot->quantity,
                    'type' => [
                        'id' => $material->type->material_type_id,
                        'name' => $material->type->material_type_name,
                        'icon' => $material->type->material_type_icon
                    ]
                ];
            })
        ]);
    }

    /**
     * Get equipment for authenticated user
     * This method retrieves the equipment associated with the currently authenticated user,
     * including their types and stats.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUserEquipment(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => $user->equipment()->with('type')->get()->map(function ($equipment) {
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
            })
        ]);
    }
}
