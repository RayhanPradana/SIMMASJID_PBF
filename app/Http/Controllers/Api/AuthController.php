<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Keuangan;
use App\Models\Jadwal;
use App\Models\Berita;
use App\Models\Acara;
use App\Models\ReservasiFasilitas;
use App\Models\Sesi;
use App\Models\Fasilitas;
use App\Models\Pembayaran;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'phone.regex' => 'Phone harus berupa angka',
            'image.image' => 'Foto Profil harus berupa gambar dengan format jpeg, png, jpg, atau svg',
            'image.max' => 'Gambar masksimal berukuran 2048 kilobyte',
            'role.required' => 'Role wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, angka, dan karakter khusus.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|regex:/^[0-9]+$/|unique:users,phone',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'role' => 'required|in:admin,jemaah',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/', // Harus ada huruf kapital
                'regex:/[a-z]/', // Harus ada huruf kecil
                'regex:/[0-9]/', // Harus ada angka
                'regex:/[@$!%*?&]/', // Harus ada karakter khusus
            ],
            'password_confirmation' => 'required',
        ], $messages );

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
        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat surel yang valid',
            'password.required' => 'Password wajib diisi.',
        ];
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], $messages);

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
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $redirectUrl = $user->role === 'admin' ? '/dashboard' : '/';

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->avatar ?? '/avatars/default.jpg',
                'image' => $user->image,
                'phone' => $user->phone,
                'address' => $user->address,

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

    public function dashboard()
    {
        $data = [
        'users' => User::all(),
        'keuangan' => Keuangan::all(),
        'jadwal' => Jadwal::all(),
        'berita' => Berita::all(),
        'acara' => Acara::all(),
        'reservasi_fasilitas' => ReservasiFasilitas::all(),
        'sesi' => Sesi::all(),
        'fasilitas' => Fasilitas::all(),
        'pembayaran' => Pembayaran::all()
    ];

    return response()->json([
        'success' => true,
        'message' => 'Data dashboard berhasil dimuat',
        'data' => $data
    ], 200);
    }


}
