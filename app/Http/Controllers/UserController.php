<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email",
            "password" => "required|string",
            "confirm_password" => "required|string",
            "photos" => "required",
            "wallet" => "required|integer",
        ]);

        if ($request['password'] != $request['confirm_password']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Password and Confirm Password doesn\'t match',
            ]);
        }
        $userDatabase = User::where("email", $request['email'])->first();
        if ($userDatabase) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User already registered... please login',
            ]);
        }
        $passwordHashed = Hash::make($request['password']);

        $user = User::create([
            "name" => $request['name'],
            "email" => $request['email'],
            "password" => $passwordHashed,
            "photos" => $request['photos'],
            "wallet" => $request['wallet'],
            'role' => "user"
        ]);
        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user->get(['name', 'email', 'photos', 'wallet', 'role']),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
