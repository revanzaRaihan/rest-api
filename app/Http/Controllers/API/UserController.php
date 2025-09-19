<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class UserController extends Controller
{
    // 🔹 List semua user
    public function index()
    {
        $users = User::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar semua user',
            'data' => $users
        ]);
    }

    // 🔹 Show detail user
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Detail user',
            'data' => $user
        ]);
    }

    // 🔹 Buat user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'  => 'required|in:admin,seller,viewer',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dibuat',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    // 🔹 Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role'  => 'sometimes|in:admin,seller,viewer',
        ]);

        if(isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
    }

    // 🔹 Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus',
        ], Response::HTTP_OK);
    }
}
