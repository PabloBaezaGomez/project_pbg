<?php

namespace App\Http\Controllers;

use App\Models\Foe;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foe_name' => 'required|string|max:255|unique:foes',
            'foe_type' => 'required|exists:foe_types,foe_type_id',
            'foe_size' => 'required|in:big,small',
            'foe_description' => 'required|string',
            'foe_icon' => 'required|string',
            'foe_image' => 'required|string'
        ]);

        try {
            $foe = Foe::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Foe created successfully',
                'data' => $foe
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating foe',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
