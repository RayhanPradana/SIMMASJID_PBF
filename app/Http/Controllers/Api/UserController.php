<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'role' => 'required|in:admin,jemaah',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);;
        }

        $image = $request->file('image');
        if ($image) {
            $image->store('public/images');
        } else {
            $image = null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image->hashName(),
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
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
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
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
                Storage::disk('public')->delete('images/' . $id->image);
            }

            // Simpan gambar baru dan ambil nama filenya
            $imageName = $request->file('image')->store('images', 'public');
            $imageName = basename($imageName);
        } else {
            $imageName = $id->image;
        }


        $id->update([
            'name' => $request->name ?? $id->name,
            'email' => $request->email ?? $id->email,
            'phone' => $request->phone ?? $id->phone,
            'address' => $request->address ?? $id->address,
            'image' => $imageName,
            'role' => $request->role ?? $id->role, // Gunakan nilai lama jika kosong
            'password' => $request->password ? bcrypt($request->password) : $id->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $id
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
}
