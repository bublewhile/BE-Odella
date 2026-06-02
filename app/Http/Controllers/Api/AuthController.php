<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'jenis_kelamin'=> 'nullable|in:L,P',
            'alamat'       => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'role'          => 'customer',
        ]);

        $token = auth('api')->login($user);
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'data'    => auth('api')->user(),
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function profile()
    {
        return response()->json([
            'success' => true,
            'data'    => auth('api')->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $validator = Validator::make($request->all(), [
            'nama'          => 'sometimes|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat'        => 'nullable|string',
            'password'      => 'nullable|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['nama', 'jenis_kelamin', 'alamat']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Profil diperbarui',
            'data'    => $user->fresh(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'success' => true,
            'token'   => auth('api')->refresh(),
        ]);
    }
}
