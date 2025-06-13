<?php

namespace App\Http\Controllers;

use App\Models\Foe;
use App\Models\FoeType;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoeController extends Controller
{
    /**
     * Display a listing of all foes.
     * This method retrieves all foes along with their types and returns them in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $foes = Foe::with('type')->get();
        return response()->json(['data' => $foes]);
    }

    /**
     * Display a specific foe by ID.
     * This method retrieves a foe along with its type and materials, returning them in a JSON response.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $foe = Foe::with(['type', 'materials.type'])->find($id);
        return response()->json([
            'data' => [
                'foe' => $foe,
                'materials' => $foe->materials
            ]
        ]);
    }

    /**
     * Get all foe types.
     * This method retrieves all foe types and returns them in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypes()
    {
        $types = FoeType::all();
        return response()->json(['data' => $types]);
    }

    /**
     * Store a new monster (foe).
     * This method allows the creation of new monsters by validating the request data,
     * handling file uploads, and storing the monster along with its materials.
     * It returns a JSON response indicating success or failure.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foe_name' => 'required|string|max:255|unique:foes',
            'foe_type' => 'required|exists:foe_types,foe_type_id',
            'foe_size' => 'required|in:Big,Small',
            'foe_description' => 'required|string',
            'foe_icon' => 'required|file|max:20500',
            'foe_image' => 'required|file|max:20500',
            'materials' => 'array',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.drop_rate' => 'required|numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();

            // Handle file uploads
            $iconPath = null;
            $imagePath = null;

            if ($request->hasFile('foe_icon')) {
                $iconFile = $request->file('foe_icon');
                $iconName = 'icon_' . $validated['foe_name'] . '.' . $iconFile->getClientOriginalExtension();
                $iconPath = $iconFile->storeAs('monster_icon', $iconName, 'public');
            }

            if ($request->hasFile('foe_image')) {
                $imageFile = $request->file('foe_image');
                $imageName = 'image_' . $validated['foe_name'] . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('monster_image', $imageName, 'public');
            }

            $foe = Foe::create([
                'foe_name' => $validated['foe_name'],
                'foe_type' => $validated['foe_type'],
                'foe_size' => $validated['foe_size'],
                'foe_description' => $validated['foe_description'],
                'foe_icon' => $iconPath ? $iconPath : null,
                'foe_image' => $imagePath ? $imagePath : null
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

            // Clean up uploaded files if monster creation fails
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error creating monster',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
