<?php

namespace App\Http\Controllers;

use App\Models\Foe;
use Illuminate\Http\Request;

class FoeController extends Controller
{
    public function index()
    {
        return response()->json(Foe::all());
    }

    public function getMaterials(Foe $foe)
    {
        return response()->json([
            'success' => true,
            'data' => $foe->materials()->with('type')->get()
        ]);
    }

    public function show(Foe $foe)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'foe' => $foe->load('type'),
                'materials' => $foe->materials()->with('type')->get()
            ]
        ]);
    }
}
