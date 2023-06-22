<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

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

    public function updateAccount(UpdateUserRequest $request) {
        $user = auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        // $user->username = $request->username;
        $user->telephone = substr($request->telephone, -12);
        $user->save();

        $response = [
            'user' => $user,
            'message' => 'Account @'.$user->username.' updated successfully',
        ];

        return response($response, 201);
    }

    public function updatePassword(UpdateUserPasswordRequest $request) {
        $user = auth()->user();

        if (!Hash::check($request->password_old, $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect. Please try again.',
                'errors' => [
                    'password_old' => [
                        'Incorrect password',
                    ]
                ],
            ], 422);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $response = [
            'user' => $user,
            'message' => 'Password for @'.$user->username.' updated successfully',
        ];

        return response($response, 201);
    }
}
