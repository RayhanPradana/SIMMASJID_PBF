<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'role' => 'required|in:admin,pengurusmesjid,jemaah',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 422);
        }

        $image = $request->file('image');
        $imagePath = null;

        if ($image) {
            $imagePath = $image->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'role' => $user->role,
                'profile_image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }


    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi error',
            'errors' => $validator->errors()
        ], 422);
    }

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'success' => false,
            'message' => 'Username atau Password Anda salah'
        ], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;

    $redirectUrl = $user->role === 'admin' ? '/dashboard' : '/landing-page';

    return response()->json([
        'success' => true,
        'message' => 'Login berhasil',
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'avatar' => $user->avatar ?? '/avatars/default.jpg',
            'image' => $user->image,

        ],
        'access_token' => $token,
        'token_type' => 'Bearer',
        'redirect' => url($redirectUrl)
    ], 200);
}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }
}
