<?php

namespace App\Http\Controllers;

use App\Models\Foe;
use App\Models\FoeType;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoeController extends Controller
{
    public function index()
    {
        $foes = Foe::with('type')->get();
        return response()->json(['data' => $foes]);
    }

    public function show($id)
    {
        $foe = Foe::with(['type', 'materials.type'])->findOrFail($id);
        return response()->json([
            'data' => [
                'foe' => $foe,
                'materials' => $foe->materials
            ]
        ]);
    }

    public function getMaterials(Foe $foe)
    {
        return response()->json([
            'success' => true,
            'data' => $foe->materials()->with('type')->get()
        ]);
    }

    public function getTypes()
    {
        $types = FoeType::all();
        return response()->json(['data' => $types]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foe_name' => 'required|string|max:255|unique:foes',
            'foe_type' => 'required|exists:foe_types,foe_type_id',
            'foe_size' => 'required|in:big,small',
            'foe_description' => 'required|string',
            'foe_icon' => 'required|string',
            'foe_image' => 'required|string',
            'materials' => 'array',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.drop_rate' => 'required|numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();
            
            $foe = Foe::create([
                'foe_name' => $validated['foe_name'],
                'foe_type' => $validated['foe_type'],
                'foe_size' => $validated['foe_size'],
                'foe_description' => $validated['foe_description'],
                'foe_icon' => $validated['foe_icon'],
                'foe_image' => $validated['foe_image']
            ]);

            // Attach materials with drop rates
            if (isset($validated['materials'])) {
                foreach ($validated['materials'] as $material) {
                    $foe->materials()->attach($material['material_id'], [
                        'drop_rate' => $material['drop_rate']
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Monster created successfully',
                'data' => $foe->load('type', 'materials')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating monster',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
