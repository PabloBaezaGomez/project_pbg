<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialUserController;

// Auth routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/foes', [FoeController::class, 'index']);
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/materials', [MaterialController::class, 'index']);

// Add these new routes
Route::get('/foes/{foe}/materials', [FoeController::class, 'getMaterials']);
Route::get('/equipment/{equipment}/materials', [EquipmentController::class, 'getMaterials']);

//Routes for only one entity, includes the associated elements
Route::get('/foes/{foe}', [FoeController::class, 'show']);
Route::get('/equipment/{equipment}', [EquipmentController::class, 'show']);
Route::get('/materials/{material}', [MaterialController::class,'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/user/data', [UserController::class, 'data']);

    // Protected routes for authenticated users
    Route::get('/user/materials', [UserController::class, 'getUserMaterials']);
    Route::get('/user/equipment', [UserController::class, 'getUserEquipment']);
    Route::post('/equipment/craft', [EquipmentController::class, 'craftEquipment']);

    Route::post('/materials/add', [MaterialUserController::class, 'addMaterial']);
});

Route::middleware(['auth:sanctum', \App\Http\Middleware\AdminOnly::class])->group(function () {
    // Your admin-only routes here
    Route::post('/foes', [FoeController::class, 'store']);
    Route::put('/foes/{foe}', [FoeController::class, 'update']);
    Route::delete('/foes/{foe}', [FoeController::class, 'destroy']);
});
