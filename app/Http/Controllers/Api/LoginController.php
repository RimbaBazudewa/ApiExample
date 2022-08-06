<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'token' => 'Bearer ' . $user->createToken('ApiExample')->plainTextToken,
                'name' => $user->name,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'status' => false,
            'token' => Null,
            'name' => Null,
            'message' => "Login Gagal Pastikan Password dan Email Benar",
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            "message" => "Berhasil Logout",
        ];
    }
}
