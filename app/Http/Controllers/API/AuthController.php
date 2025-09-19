<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // =========================
    // REGISTER
    // =========================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // Optional: izinkan input role jika ingin assign manual dari postman/frontend
            // 'role' => 'in:admin,seller,viewer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'viewer', // default role saat register
            // Atau jika kamu izinkan role dari request:
            // 'role' => $request->role ?? 'viewer'
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil mendaftar',
            'data' => [
                'user' => $user,
                'token' => $this->respondWithToken($token)
            ]
        ], 201);
    }

    // =========================
    // LOGIN
    // =========================
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|filled',
            'password' => 'required|string|min:6|filled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email dan password harus diisi',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credential'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token gagal dibuat',
                'error' => $e->getMessage()
            ], 500);
        }

        $user = JWTAuth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil login',
            'data' => array_merge(
                $this->respondWithToken($token),
                [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar ?? null,
                        'role' => $user->role
                    ]
                ]
            )
        ]);
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil logout'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal logout, token tidak valid',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =========================
    // REFRESH TOKEN
    // =========================
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'Token telah diperbarui',
                'data' => $this->respondWithToken($newToken)
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui token',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    // =========================
    // GET PROFILE
    // =========================
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'status' => 'success',
                'message' => 'User profile',
                'data' => $user,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid atau expired token',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    // =========================
    // HELPER: RESPOND TOKEN
    // =========================
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
    }
}
