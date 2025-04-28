<?php

namespace App\Http\Controllers;

use App\Models\MaterialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialUserController extends Controller
{
    public function addMaterial(Request $request)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.amount' => 'required|numeric|min:0'
        ]);

        $userId = Auth::id();
        $results = [];
        
        DB::beginTransaction();
        try {
            foreach ($request->materials as $material) {
                // Use raw SQL update to properly increment the quantity
                $affected = DB::table('material_user')
                    ->where('user_id', $userId)
                    ->where('material_id', $material['material_id'])
                    ->increment('quantity', $material['amount']);

                // If no row was updated, create a new one
                if ($affected === 0) {
                    $materialUser = MaterialUser::create([
                        'user_id' => $userId,
                        'material_id' => $material['material_id'],
                        'quantity' => $material['amount']
                    ]);
                }

                // Get the updated/created record
                $results[] = MaterialUser::where('user_id', $userId)
                    ->where('material_id', $material['material_id'])
                    ->first();
            }
            
            DB::commit();

            return response()->json([
                'message' => 'Materials added successfully',
                'data' => $results
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error adding materials',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}