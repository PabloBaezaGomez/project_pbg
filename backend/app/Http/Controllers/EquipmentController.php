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
        return response()->json(Equipment::all());
    }

    public function userEquipment()
    {
        $user = Auth::user();
        $equipment = $user->equipment; // Obtiene los equipos desde la tabla intermedia
        return response()->json($equipment);
    }

    public function getMaterials(Equipment $equipment)
    {
        return response()->json([
            'success' => true,
            'data' => $equipment->materials()->with('type')->get()
        ]);
    }

    public function show(Equipment $equipment){
        return response()->json([
            'success' => true,
            'data' => [
                'equipment'=>$equipment->load('materials'),
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
}
