<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        return response()->json(Material::all());
    }

    public function userMaterials()
    {
        $user = Auth::user();
        $materials = $user->materials; // Obtiene los materiales desde la tabla intermedia
        return response()->json($materials);
    }

    public function show(Material $material)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'material' => $material->load('type'),
                'foes' => $material->foes()
                    ->with('type')
                    ->select('foes.foe_id', 'foes.foe_name', 'foes.foe_type', 'foes.foe_icon')
                    ->get()
                    ->map(function ($foe) {
                        return [
                            'name' => $foe->foe_name,
                            'type' => $foe->type->type_name,
                            'icon' => $foe->foe_icon,
                            'drop_rate' => $foe->pivot->drop_rate
                        ];
                    }),
                'equipment' => $material->equipment()
                    ->with('type')
                    ->select('equipment.equipment_id', 'equipment.equipment_name', 'equipment.equipment_type')
                    ->get()
                    ->map(function ($equipment) {
                        return [
                            'name' => $equipment->equipment_name,
                            'type' => $equipment->type->type_name,
                            'required_quantity' => $equipment->pivot->required_quantity
                        ];
                    })
            ]
        ]);
    }
}
