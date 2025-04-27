<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
