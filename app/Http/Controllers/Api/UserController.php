<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
