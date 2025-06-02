<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Acara;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AcaraController extends Controller
{
    public function index()
    {
        $acara = Acara::all()->map(function ($item) {
            $item->gambar_url = $item->gambar ? asset('storage/' . $item->gambar) : null;
            return $item;
        });
        return response()->json($acara);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_acara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:tersedia,tidaktersedia',
        ], [
            'nama_acara.required' => 'Nama acara wajib diisi.',
            'nama_acara.string' => 'Nama acara harus berupa teks.',
            'nama_acara.max' => 'Nama acara maksimal 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'harga.required' => 'Harga acara wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus bernilai tersedia atau tidaktersedia.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Upload gambar jika ada
        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('acara', 'public')
            : null;

        $acara = Acara::create(array_merge(
            $request->only(['nama_acara', 'deskripsi', 'harga', 'status']),
            ['gambar' => $gambarPath]
        ));

        $acara->gambar_url = $gambarPath ? asset('storage/' . $gambarPath) : null;

        return response()->json([
            'status' => 'success',
            'message' => 'Data acara berhasil disimpan.',
            'data' => $acara,
        ], 201);
    }

    public function show($id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data acara tidak ditemukan.'
            ], 404);
        }

        $acara->gambar_url = $acara->gambar ? asset('storage/' . $acara->gambar) : null;
        return response()->json([
            'status' => 'success',
            'data' => $acara
        ]);
    }

    public function update(Request $request, $id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data acara tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_acara' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'harga' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:tersedia,tidaktersedia',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            if ($acara->gambar) {
                Storage::disk('public')->delete($acara->gambar);
            }
            $gambarPath = $request->file('gambar')->store('acara', 'public');
            $acara->gambar = $gambarPath;
        }

        $acara->update($request->only(['nama_acara', 'deskripsi', 'harga', 'status']));
        $acara->gambar_url = $acara->gambar ? asset('storage/' . $acara->gambar) : null;

        return response()->json([
            'status' => 'success',
            'message' => 'Data acara berhasil diperbarui.',
            'data' => $acara,
        ]);
    }

    public function destroy($id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data acara tidak ditemukan.'
            ], 404);
        }

        if ($acara->gambar) {
            Storage::disk('public')->delete($acara->gambar);
        }

        $acara->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data acara berhasil dihapus.',
        ]);
    }
}
