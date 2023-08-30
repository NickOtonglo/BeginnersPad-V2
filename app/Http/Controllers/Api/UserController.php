<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $user = User::where('id', auth()->user()->id)->first();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->telephone = substr($request->telephone, -12);
        $user->save();

        $response = [
            'user' => $user,
            'message' => 'Account @'.$user->username.' updated successfully.',
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
            'message' => 'Password for @'.$user->username.' updated successfully.',
        ];

        return response($response, 201);
    }

    public function updateAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $filename = time()
                        .'_'
                        .$user->username
                        .'.'
                        .$request->avatar->extension();
            // $request->file('avatar')->storeAs('public/images/user/avatar/'.$user->username, $filename);
            $request->file('avatar')->storeAs('images/user/avatar/'.$user->username, $filename, ['disk' => 'public_uploads']);

            // Delete old avatar
            Storage::disk('public_uploads')->delete('images/user/avatar/'.$user->username.'/'.$user->avatar);
            
            $user->avatar = $filename;
            $user->save();

            $response = [
                'user' => $user,
                'message' => 'Avatar for @'.$user->username.' updated successfully.',
            ];
    
            return response($response, 201);
        }

        return response()->json([
            'message' => 'An error occured. Please try again.',
            'errors' => [
                'avatar' => [
                    'Avatar missing in request',
                ]
            ],
        ], 422);
    }

    public function removeAvatar() {
        $user = auth()->user();
        
        // Storage::disk('public_uploads')->delete('images/user/avatar/'.$user->username.'/'.$user->avatar);

        $user->avatar = null;
        $user->save();

        Storage::disk('public_uploads')->deleteDirectory('images/user/avatar/'.$user->username);

        $response = [
            'user' => $user,
            'message' => 'Avatar for @'.$user->username.' removed successfully.',
        ];

        return response($response, 201);
    }

    public function updateBrandAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required',
        ]);

        $brand = auth()->user()->brand;
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $filename = time()
                        .'_'
                        .$brand->name
                        .'.'
                        .$request->avatar->extension();
            // $request->file('avatar')->storeAs('public/images/brand/avatar/'.$brand->name, $filename);
            $request->file('avatar')->storeAs('images/brand/avatar/'.$user->username, $filename, ['disk' => 'public_uploads']);

            // Delete old avatar
            Storage::disk('public_uploads')->delete('images/brand/avatar/'.$user->username.'/'.$brand->avatar);
            
            $brand->avatar = $filename;
            $brand->save();

            $response = [
                'brand' => $brand,
                'message' => 'Avatar for brand, '.$brand->name.', updated successfully.',
            ];
    
            return response($response, 201);
        }

        return response()->json([
            'message' => 'An error occured. Please try again.',
            'errors' => [
                'avatar' => [
                    'Avatar missing in request',
                ]
            ],
        ], 422);
    }

    public function removeBrandAvatar() {
        $brand = auth()->user()->brand;
        
        // Storage::disk('public_uploads')->delete('images/brand/avatar/'.$user->username.'/'.$brand->avatar);

        $brand->avatar = null;
        $brand->save();

        Storage::disk('public_uploads')->deleteDirectory('images/brand/avatar/'.$brand->name);

        $response = [
            'brand' => $brand,
            'message' => 'Avatar for brand, '.$brand->name.', updated successfully.',
        ];

        return response($response, 201);
    }

    public function updateBrand(UpdateBrandRequest $request) {
        $brand = auth()->user()->brand;
        $brand->name = $request->name;
        $brand->statement = $request->statement;
        $brand->user_id = auth()->user()->id;
        $brand->save();

        $response = [
            'brand' => $brand,
            'message' => 'Information for brand, '.$brand->name.', updated successfully.',
        ];

        return response($response, 201);
    }
}
