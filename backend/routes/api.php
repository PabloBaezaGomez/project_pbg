<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialUserController;
use App\Http\Middleware\AdminOnly;

// Auth routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

// Public routes for listing all entities of one type
Route::get('/foes', [FoeController::class, 'index']);
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/materials', [MaterialController::class, 'index']);

//Routes for only one entity, includes the associated elements
Route::get('/foes/{foe}', [FoeController::class, 'show']);
Route::get('/equipment/{equipment}', [EquipmentController::class, 'show']);
Route::get('/materials/{material}', [MaterialController::class,'show']);

// Protected routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/user/data', [UserController::class, 'data']);

    Route::get('/user/materials', [UserController::class, 'getUserMaterials']);
    Route::get('/user/equipment', [UserController::class, 'getUserEquipment']);
    Route::post('/equipment/craft', [EquipmentController::class, 'craftEquipment']);

    Route::post('/materials/add', [MaterialUserController::class, 'addMaterial']);
});

Route::get('/foe-types', [FoeController::class, 'getTypes']);
Route::get('/material-types', [MaterialController::class, 'getTypes']);
Route::get('/equipment-types', [EquipmentController::class, 'getTypes']);

Route::middleware(['auth:sanctum', AdminOnly::class])->group(function () {
    // Routes for admin users to manage foes, equipment, and materials
    Route::post('/foes', [FoeController::class, 'store']);
    Route::post('/equipment', [EquipmentController::class, 'store']);
    Route::post('/materials', [MaterialController::class, 'store']); // Added materials creation route
});
