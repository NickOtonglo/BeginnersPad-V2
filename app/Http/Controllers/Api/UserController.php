<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAuthenticatedUser() {
        $username = auth()->user()->username;
        $role = auth()->user()->role->title;

        return response()->json([
            'username' => $username,
            'role' => $role,
        ]);
    }

    public function getAuthenticatedUserAccount() {
        $user = auth()->user();

        return response()->json(new UserResource($user));
    }
}
