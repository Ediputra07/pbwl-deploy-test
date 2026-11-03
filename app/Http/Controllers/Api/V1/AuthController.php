<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        return response()->json([
            'message'    => 'Login berhasil.',
            'token'      => $user->createToken('frontend-praktikum')->plainTextToken,
            'token_type' => 'Bearer',
            'user'       => $user->only(['id', 'name', 'email']),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['data' => $request->user()->only(['id', 'name', 'email'])]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // hanya token yang dipakai

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
