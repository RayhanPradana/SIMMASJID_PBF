<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {

        $messages = [
            'role.required' => 'Role wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, angka, dan karakter khusus.',
            'password.regex:/[A-Z]/' => 'Password harus mengandung setidaknya satu huruf kapital.',
            'password.regex:/[a-z]/' => 'Password harus mengandung setidaknya satu huruf kecil.',
            'password.regex:/[0-9]/' => 'Password harus mengandung setidaknya satu angka.',
            'password.regex:/[@$!%?&]/' => 'Password harus mengandung setidaknya satu karakter khusus (@$!%?&).',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:255|unique:users,phone',
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
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors(),
            ], 422);;
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

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'role' => $user->role,
                'profile_image_url' => $imagePath ? Storage::url($imagePath) : null,
            ],
        ], 201);
    }

    public function show(User $id)
    {
        return User::find($id);
    }

    public function update(Request $request, User $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id->id . '|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'role' => 'nullable|in:admin,jemaah',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]+$/'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($id->image) {
                Storage::disk('public')->delete($id->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $id->image = $imagePath;
        }
        // $imagePath = $id->image;

        // if ($request->hasFile('image')) {
        //     // Hapus gambar lama jika ada
        //     if ($id->image) {
        //         Storage::disk('public')->delete($id->image);
        //     }

        //     $imagePath = $request->file('image')->store('images', 'public');
        // }

        $id->name = $request->name ?? $id->name;
        $id->email = $request->email ?? $id->email;
        $id->phone = $request->phone ?? $id->phone;
        $id->address = $request->address ?? $id->address;
        $id->role = $request->role ?? $id->role;
        $id->password = $request->password ? bcrypt($request->password) : $id->password;
        $id->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => [
                'id' => $id->id,
                'name' => $id->name,
                'email' => $id->email,
                'phone' => $id->phone,
                'address' => $id->address,
                'image' => $id->image, 
                'role' => $id->role,
            ]
        ], 200);
    }


    public function destroy(User $id)
    {
        $id->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ], 200);
    }

    public function updatePassword(Request $request)
    {

        $messages = [
            'old_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password wajib diisi.',
            'new_password.min' => 'Password minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, angka, dan karakter khusus.',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ];

        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password_confirmation' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/'
            ],
        ], $messages);

        $validator->after(function ($validator) use ($request, $user) {
            if (!Hash::check($request->old_password, $user->password)) {
                $validator->errors()->add('old_password', 'Password lama tidak sesuai.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255' . $user->id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:500' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'phone' => $request->phone ?? $user->phone,
            'address' => $request->address ?? $user->address,
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function updatePhoto(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $user->image;
        }


        $user->image = $imagePath;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui',
            'image_url' => asset('storage/' . $imagePath),
        ]);
    }
}