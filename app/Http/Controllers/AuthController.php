<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // return response
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        // validate incoming request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // check credentials if wrong then return 401
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // finding user
        $user = Auth::user();

        // create token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // return response
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function logout(Request $request)
    {
        // delete token
        $request->user()->currentAccessToken()->delete();

        // return response
        return response()->json([
            'message' => 'Logged out successfully!'
        ], 200);
    }
}
