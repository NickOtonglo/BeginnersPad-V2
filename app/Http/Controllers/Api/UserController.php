<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserAdminRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\HelpTicketRepResource;
use App\Http\Resources\UserAdminResource;
use App\Http\Resources\UserLogResource;
use App\Http\Resources\UserResource;
use App\Models\Brand;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLog;
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
        if ($user->username != $request->username && User::where('username', $request->username)->first()) {
            return response()->json([
                'message' => "The username '".$request->username."' has already been taken.",
                'errors' => [
                    'username' => [
                        "Username  has already been taken",
                    ]
                ],
            ], 422);
        }
        if ($user->telephone != $request->telephone && User::where('telephone', $request->telephone)->first()) {
            return response()->json([
                'message' => "The phone number '".$request->telephone."' has already been taken.",
                'errors' => [
                    'telephone' => [
                        "The phone number has already been taken",
                    ]
                ],
            ], 422);
        }
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->telephone = substr($request->telephone, -12);
        $user->save();

        $response = [
            'user' => $user,
            'model' => 'User',
            'key' => $user->username,
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
                        .$user->username
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
                'message' => 'Avatar for brand '.$brand->name.' updated successfully.',
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

        Storage::disk('public_uploads')->deleteDirectory('images/brand/avatar/'.auth()->user()->username);

        $response = [
            'brand' => $brand,
            'message' => 'Avatar for brand '.$brand->name.' removed successfully.',
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
            'message' => 'Information for brand '.$brand->name.' updated successfully.',
        ];

        return response($response, 201);
    }

    public function saveBrand(Request $request) {
        $request->validate([
            'avatar' => 'required',
            'name' => 'required|min:1|max:50',
            'statement' => 'required|min:1',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $filename = time()
                        .'_'
                        .$user->username
                        .'.'
                        .$request->avatar->extension();
            // $request->file('avatar')->storeAs('public/images/brand/avatar/'.$brand->name, $filename);
            $request->file('avatar')->storeAs('images/brand/avatar/'.$user->username, $filename, ['disk' => 'public_uploads']);

            $brand = new Brand;
            $brand->name = $request->name;
            $brand->statement = $request->statement;
            $brand->avatar = $filename;
            $brand->user_id = auth()->user()->id;
            $brand->save();

            $response = [
                'brand' => $brand,
                'message' => "New brand '".$brand->name."' created successfully.",
            ];
    
            return response($response, 201);
            // return $data;
        } else {
            return response()->json([
                'message' => 'An error occured. Please try again.',
                'errors' => [
                    'avatar' => [
                        'Avatar missing in request',
                    ]
                ],
            ], 422);
        }
    }

    public function getRepresentativesForTickets() {
        $user = User::where('username', auth()->user()->username)->get();
        $reps = User::whereBetween('role_id', [1, 3])->where('username', '!=', auth()->user()->username)->orderBy('username')->get();
        $combined = $user->merge($reps);
        return HelpTicketRepResource::collection($combined);
    }

    public function getAllUsers() {
        $request = request('sort');
        
        $users = User::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('firstname', 'like', '%'.request('search_global').'%')
                ->orWhere('lastname', 'like', '%'.request('search_global').'%')
                ->orWhere('username', 'like', '%'.request('search_global').'%');
            });
        })->where('username', '!=', auth()->user()->username);

        if (!request('sort')) {
            $users = $users->orderBy('role_id', 'ASC')->orderBy('firstname', 'ASC')->paginate(50);
        } else {
            $users = $users->orderBy('created_at', $request)->paginate(50);
        }
        
        return UserAdminResource::collection($users);
    }

    public function getUsersByRole(Role $role) {
        $users = User::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('firstname', 'like', '%'.request('search_global').'%')
                  ->orWhere('lastname', 'like', '%'.request('search_global').'%')
                  ->orWhere('username', 'like', '%'.request('search_global').'%');
            });
        })->where('role_id', $role->id)->where('username', '!=', auth()->user()->username)->orderBy('role_id', 'ASC')->orderBy('firstname', 'ASC')->paginate(50);
        return UserAdminResource::collection($users);
    }

    public function getRoles() {
        $roles = Role::get();
        return response()->json([
            'data' => $roles,
        ]);
    }

    public function saveUser(SaveUserAdminRequest $request) {
        $user = auth()->user();

        $phone = substr($request->telephone, -12);
        if (User::where('telephone', $phone)->first()) {
            return response()->json([
                'message' => "The phone number '" . $request->telephone . "' has already been taken.",
                'errors' => [
                    'telephone' => [
                        "The phone number has already been taken",
                    ]
                ],
            ], 422);
        }

        if ($user->role_id >= $request->role_id) {
            return response()->json([
                'message' => 'You are not authorised to interact with this user!',
                'errors' => [
                    'user' => [
                        'role_id' => [
                            'User is not authorised to perform this action',
                        ]
                    ]
                ],
            ], 422);
        }

        $data = new User;
        $data->firstname = $request->firstname;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $data->username = $request->username;
        $data->telephone = $phone;
        $data->role_id = $request->role_id;
        $data->password = bcrypt($request->password);
        $data->status = 'preactive';
        $data->save();

        $response = [
            'user' => $data,
            'model' => 'User',
            'key' => $data->username,
            'message' => 'User @'.$data->username.' created successfully',
        ];

        return response($response, 201);
    }

    public function getUser(string $username) {
        $user = User::where('username', $username)->first();
        return new UserAdminResource($user);
    }

    public function updateUser(string $username, Request $request) {
        $user = User::where('username', $username)->first();
        if ($user->username != $request->username && User::where('username', $request->username)->first()) {
            return response()->json([
                'message' => "The username '".$request->username."' has already been taken.",
                'errors' => [
                    'username' => [
                        "Username has already been taken",
                    ]
                ],
            ], 422);
        }
        if ($user->telephone != $request->telephone && User::where('telephone', $request->telephone)->first()) {
            return response()->json([
                'message' => "The phone number '".$request->telephone."' has already been taken.",
                'errors' => [
                    'telephone' => [
                        "Phone number has already been taken",
                    ]
                ],
            ], 422);
        }
        if ($request->firstname){
            $user->firstname = $request->firstname;
        }
        if ($request->lastname){
            $user->lastname = $request->lastname;
        }
        if ($request->email){
            $user->email = $request->email;
        }
        if ($request->username){
            $user->username = $request->username;
        }
        if ($request->telephone){
            $user->telephone = substr($request->telephone, -12);
        }
        if ($request->status) {
            if (auth()->user()->role_id >= $user->role_id) {
                return response()->json([
                    'message' => 'You are not authorised to interact with this user!',
                    'errors' => [
                        'user' => [
                            'role_id' => [
                                'User is not authorised to perform this action',
                            ]
                        ]
                    ],
                ], 422);
            }

            if ($request->status == 'Restore') {
                $user->status = 'active';
            }
            if ($request->status == 'Delete') {
                if ($user->userFavourites) {
                    $user->userFavourites()->delete();
                }
                if ($user->propertyReviews) {
                    $user->propertyReviews()->delete();
                }
                if ($user->properties) {
                    $user->properties()->delete();
                }
                if ($user->brand) {
                    $user->brand()->delete();
                }
                if ($user->articles) {
                    $user->articles()->delete();
                }
                $user->delete();

                return response([
                    'user' => response()->noContent(),
                    'model' => 'User',
                    'key' => $user->username,
                    'message' => 'Account @'.$user->username.' deleted successfully.',
                ], 201);
            }
            if ($request->status == 'Suspend') {
                $user->status = 'suspended';
            }
        }
        $user->save();

        $response = [
            'user' => $user,
            'model' => 'User',
            'key' => $user->username,
            'message' => 'Account @'.$user->username.' updated successfully.',
        ];

        return response($response, 201);
    }

    public function getLogs() {
        $logs = UserLog::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('firstname', 'like', '%'.request('search_global').'%')
                ->orWhere('lastname', 'like', '%'.request('search_global').'%')
                ->orWhere('username', 'like', '%'.request('search_global').'%');
            });
        })->latest()->paginate(200);
        return UserLogResource::collection($logs);
    }
}
