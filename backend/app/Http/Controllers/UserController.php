<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Material::all());
    }

    /**
     * Get materials for authenticated user
     */
    public function getUserMaterials(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => $user->materials()->get()
        ]);
    }

    /**
     * Get equipment for authenticated user
     */
    public function getUserEquipment(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => $user->equipment()->get()
        ]);
    }
}
