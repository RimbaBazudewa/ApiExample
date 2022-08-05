<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'token' => $user->createToken('ApiExample')->plainTextToken,
                'name' => $user->name,
                'message' => 'success'
            ]);
        }
        return response([
            'status' => false,
            'token' => Null,
            'name' => Null,
            'message' => "Login Gagal Pastikan Password dan Email Benar",
        ]);
    }
    public function register(RegisterRequest $request)
    {
    }
}
