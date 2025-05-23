<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('user_email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->user_password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255|unique:users',
            'user_email' => 'required|string|email|max:255|unique:users',
            'user_password' => 'required|string|min:8',
        ]);

        try {
            $user = User::create([
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
                'user_password' => Hash::make($validated['user_password']),
                'user_type' => 'user', // Default user type
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error registering user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}