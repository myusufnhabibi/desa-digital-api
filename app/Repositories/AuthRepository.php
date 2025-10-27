<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class AuthRepository implements \App\Interfaces\AuthInterface
{
    // public function register(array $data);
    public function login(array $data) {
        if (!Auth::guard('web')->attempt($data)) {
            return response([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'success' => true,
            'token' => $token,
            'message' => 'Login Successful'
        ], 200);
    }

    public function logout() {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
            'message' => 'Logout Successful'
        ], 200);
    }

    public function me() {
        if (Auth::check()) {
            $user = Auth::user();

            $user->load('roles.permissions');

            $permissions = $user->roles->flatMap->permission->pluck('name');

            $role = $user->roles->first() ? $user->roles->first()->name : null;

            return response([
                'message' => 'User Data',
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                    'permissions' => $permissions
                ]
            ], 200);
        }

        return response([
            'success' => false,
            'message' => 'You are not logged in'
        ], 401);
    }
}
