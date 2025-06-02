<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all()->map(function ($item) {
            $item->gambar_url = $item->gambar ? asset('storage/' . $item->gambar) : null;
            return $item;
        });
        return response()->json($fasilitas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan'     => 'nullable|string|max:500',
            'harga'          => 'required|numeric|min:0',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'         => 'required|in:tersedia,tidaktersedia',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.string'   => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max'      => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.string'       => 'Keterangan harus berupa teks.',
            'keterangan.max'          => 'Keterangan maksimal 500 karakter.',
            'harga.required'          => 'Harga wajib diisi.',
            'harga.numeric'           => 'Harga harus berupa angka.',
            'harga.min'               => 'Harga tidak boleh kurang dari 0.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max'      => 'Ukuran gambar maksimal 2MB.',
            'status.required'         => 'Status wajib diisi.',
            'status.in'               => 'Status harus bernilai "tersedia" atau "tidaktersedia".',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Upload gambar jika ada
        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('fasilitas', 'public')
            : null;

        $fasilitas = Fasilitas::create(array_merge(
            $request->only(['nama_fasilitas', 'keterangan', 'harga', 'status']),
            ['gambar' => $gambarPath]
        ));

        // Add gambar_url to response
        $fasilitas->gambar_url = $gambarPath ? asset('storage/' . $gambarPath) : null;

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil disimpan.',
            'data'    => $fasilitas,
        ], 201);
    }

    public function show(Fasilitas $id)
    {
        $id->gambar_url = $id->gambar ? asset('storage/' . $id->gambar) : null;
        return response()->json($id);
    }

    public function update(Request $request, Fasilitas $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'nullable|string|max:255',
            'keterangan'     => 'nullable|string|max:500',
            'harga'          => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'         => 'required|in:tersedia,tidaktersedia',
        ], [
            'nama_fasilitas.string'   => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max'      => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.string'       => 'Keterangan harus berupa teks.',
            'keterangan.max'          => 'Keterangan maksimal 500 karakter.',
            'harga.numeric'           => 'Harga harus berupa angka.',
            'harga.min'               => 'Harga tidak boleh kurang dari 0.',
            'status.required'         => 'Status wajib diisi.',
            'status.in'               => 'Status harus bernilai "tersedia" atau "tidaktersedia".',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($id->gambar) {
                Storage::disk('public')->delete($id->gambar);
            }
            $gambarPath = $request->file('gambar')->store('fasilitas', 'public');
            $id->gambar = $gambarPath;
        }

        $id->update($request->only(['nama_fasilitas', 'keterangan', 'harga', 'status']));

        // Add gambar_url to response
        $id->gambar_url = $id->gambar ? asset('storage/' . $id->gambar) : null;

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil diperbarui.',
            'data'    => $id,
        ]);
    }

    public function destroy(Fasilitas $id)
    {
        // Delete image if exists
        if ($id->gambar) {
            Storage::disk('public')->delete($id->gambar);
        }

        $id->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil dihapus.',
        ]);
    }
}
