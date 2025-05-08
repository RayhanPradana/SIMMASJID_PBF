<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon; // Tambahkan ini untuk mendapatkan waktu saat ini

class RegisterController extends Controller
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $imagePath = null;

        if ($image) {
            $imagePath = $image->store('public/images');
            $imagePath = basename($imagePath); // Ambil hanya nama file, bukan path lengkap
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath, // Simpan nama file atau null jika tidak ada gambar
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'email_verified_at' => Carbon::now(), // Set email langsung terverifikasi
        ]);

        if ($user) {
            return response()->json([
                'message' => 'User registered successfully'], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
