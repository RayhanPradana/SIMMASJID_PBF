<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index()
    {
        return Jadwal::all();
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => 'required|string|max:50',
            'waktu' => 'required|string|max:50',
            'tempat' => 'required|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.string' => 'Nama kegiatan harus berupa teks.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
            'hari.required' => 'Hari kegiatan wajib diisi.',
            'hari.string' => 'Hari harus berupa teks.',
            'hari.max' => 'Hari maksimal 50 karakter.',
            'waktu.required' => 'Waktu kegiatan wajib diisi.',
            'waktu.string' => 'Waktu harus berupa teks.',
            'waktu.max' => 'Waktu maksimal 50 karakter.',
            'tempat.required' => 'Tempat kegiatan wajib diisi.',
            'tempat.string' => 'Tempat harus berupa teks.',
            'tempat.max' => 'Tempat maksimal 255 karakter.',
            'penanggung_jawab.string' => 'Penanggung jawab harus berupa teks.',
            'penanggung_jawab.max' => 'Penanggung jawab maksimal 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $jadwal = Jadwal::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil disimpan.',
            'data' => $jadwal,
        ], 201);
    }

    public function show(Jadwal $id)
    {
        return response()->json($id);
    }

    public function update(Request $request, Jadwal $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => 'required|string|max:50',
            'waktu' => 'required|string|max:50',
            'tempat' => 'required|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.string' => 'Nama kegiatan harus berupa teks.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
            'hari.required' => 'Hari kegiatan wajib diisi.',
            'hari.string' => 'Hari harus berupa teks.',
            'hari.max' => 'Hari maksimal 50 karakter.',
            'waktu.required' => 'Waktu kegiatan wajib diisi.',
            'waktu.string' => 'Waktu harus berupa teks.',
            'waktu.max' => 'Waktu maksimal 50 karakter.',
            'tempat.required' => 'Tempat kegiatan wajib diisi.',
            'tempat.string' => 'Tempat harus berupa teks.',
            'tempat.max' => 'Tempat maksimal 255 karakter.',
            'penanggung_jawab.string' => 'Penanggung jawab harus berupa teks.',
            'penanggung_jawab.max' => 'Penanggung jawab maksimal 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $id->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil diperbarui.',
            'data' => $id,
        ]);
    }

    public function destroy(Jadwal $id)
    {
        $id->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil dihapus.',
        ]);
    }
}
