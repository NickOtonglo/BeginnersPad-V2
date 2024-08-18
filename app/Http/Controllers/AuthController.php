<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\SystemController;
use App\Http\Controllers\Api\UserCreditController;
use App\Http\Requests\SaveUserRequest;
use App\Models\System;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(SaveUserRequest $request) {
        $user = new User;
        $user->firstname = $request->fname;
        $user->lastname = $request->lname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->telephone = substr($request->telephone, -12);
        $user->role_id = $request->user_type;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user->role_id == 5 || $user->role_id == 4) {
            if ($user->role->title == 'Lister') {
                app(UserCreditController::class)->store(0, $user, 'app/Http/Controllers/AuthController.php');
            }
            
            if ($user->role->title == 'Beginner') {
                $user_credit_amount = System::where('key', 'user_credit_amount')->first()->value;
                app(UserCreditController::class)->store((int)$user_credit_amount, $user, 'app/Http/Controllers/AuthController.php');
            }
        }

        $response = [
            'user' => $user,
            'model' => 'User',
            'key' => $user->username,
            'message' => 'User @'.$user->username.' created successfully',
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials, $request->remember)) {
            return response()->json([
                'message' => 'The given data was invalid. Please check your credentials and try again.',
                'errors' => [
                    'credentials' => [
                        'Invalid credentials',
                    ]
                ],
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('user-token', [
            'listing.create',
            'listing.update'
        ])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        auth()->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect('/');
    }

    public function forgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                ? with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }

    public function checkPassword($password) {
        $user = auth()->user();
        if (Hash::check($password, $user->password)) {
            return true;
        }
        return false;
    }
}
