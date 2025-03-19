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
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.string' => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max' => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan data jika validasi berhasil
        $fasilitas = Fasilitas::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil disimpan.',
            'data' => $fasilitas,
        ], 201);
    }

    public function show(Fasilitas $fasilitas)
    {
        return response()->json($fasilitas);
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.string' => 'Nama fasilitas harus berupa teks.',
            'nama_fasilitas.max' => 'Nama fasilitas maksimal 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data jika validasi berhasil
        $fasilitas->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil diperbarui.',
            'data' => $fasilitas,
        ]);
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas berhasil dihapus.',
        ]);
    }
}
