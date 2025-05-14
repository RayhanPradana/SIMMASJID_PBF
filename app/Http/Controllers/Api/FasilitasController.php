<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Validator;

class FasilitasController extends Controller
{
    public function index()
    {
        return Fasilitas::all();
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
            'harga' => 'required|numeric|min:0', // validasi harga
            'status' => 'required|in:tersedia,tidaktersedia', // validasi status
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.string' => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max' => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus bernilai "tersedia" atau "tidaktersedia".',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan data jika validasi berhasil
        $fasilitas = Fasilitas::create($request->only(['nama_fasilitas', 'keterangan', 'harga', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil disimpan.',
            'data' => $fasilitas,
        ], 201);
    }

    public function show(Fasilitas $id)
    {
        return response()->json($id);
    }

    public function update(Request $request, Fasilitas $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500',
            'harga' => 'nullable|numeric|min:0', // validasi harga
            'status' => 'required|in:tersedia,tidaktersedia', // validasi status
        ], [
            'nama_fasilitas.string' => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max' => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus bernilai "tersedia" atau "tidak tersedia".',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data jika validasi berhasil
        $id->update($request->only(['nama_fasilitas', 'keterangan', 'harga', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil diperbarui.',
            'data' => $id,
        ]);
    }

    public function destroy(Fasilitas $id)
    {
        $id->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil dihapus.',
        ]);
    }
}
