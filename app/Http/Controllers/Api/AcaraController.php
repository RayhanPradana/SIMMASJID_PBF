<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Acara;
use Illuminate\Support\Facades\Validator;

class AcaraController extends Controller
{
    public function index()
    {
        return Acara::all();
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_acara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'harga' => 'required|numeric|min:0',
        ], [
            'nama_acara.required' => 'Nama acara wajib diisi.',
            'nama_acara.string' => 'Nama acara harus berupa teks.',
            'nama_acara.max' => 'Nama acara maksimal 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'harga.required' => 'Harga acara wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Membuat data untuk disimpan
        $data = $request->only(['nama_acara', 'deskripsi', 'harga']);

        // Simpan data
        $acara = Acara::create($data);

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

        return response()->json([
            'status' => 'success',
            'data' => $acara
        ]);
    }

    public function update(Request $request, $id)
    {
        // Cari acara berdasarkan ID
        $acara = Acara::find($id);

        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data acara tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_acara' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'harga' => 'nullable|numeric|min:0',
        ], [
            'nama_acara.string' => 'Nama acara harus berupa teks.',
            'nama_acara.max' => 'Nama acara maksimal 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data
        $acara->update($request->only(['nama_acara', 'deskripsi', 'harga']));

        return response()->json([
            'status' => 'success',
            'message' => 'Data acara berhasil diperbarui.',
            'data' => $acara,
        ]);
    }

    public function destroy($id)
    {
        // Cari acara berdasarkan ID
        $acara = Acara::find($id);

        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data acara tidak ditemukan.'
            ], 404);
        }

        $acara->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data acara berhasil dihapus.',
        ]);
    }
}
