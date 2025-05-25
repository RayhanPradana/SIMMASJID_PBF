<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sesi;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    /**
     * Menampilkan semua data sesi.
     */
    public function index()
    {
        $sesi = Sesi::all();
        return response()->json($sesi);
    }

    /**
     * Menyimpan data sesi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'deskripsi'   => 'nullable|string|max:255',
        ], [
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'    => 'Jam selesai harus setelah jam mulai.',
            'deskripsi.string'     => 'Deskripsi harus berupa teks.',
            'deskripsi.max'        => 'Deskripsi maksimal 255 karakter.',
        ]);

        $sesi = Sesi::create($validated);

        return response()->json([
            'message' => 'Sesi berhasil ditambahkan.',
            'data' => $sesi
        ], 201);
    }

    /**
     * Menampilkan data sesi berdasarkan ID.
     */
    public function show($id)
    {
        $sesi = Sesi::findOrFail($id);
        return response()->json($sesi);
    }

    /**
     * Memperbarui data sesi.
     */
    public function update(Request $request, $id)
    {
        $sesi = Sesi::findOrFail($id);

        $validated = $request->validate([
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'deskripsi'   => 'nullable|string|max:255',
        ], [
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'    => 'Jam selesai harus setelah jam mulai.',
            'deskripsi.string'     => 'Deskripsi harus berupa teks.',
            'deskripsi.max'        => 'Deskripsi maksimal 255 karakter.',
        ]);

        $sesi->update($validated);

        return response()->json([
            'message' => 'Sesi berhasil diperbarui.',
            'data' => $sesi
        ]);
    }

    /**
     * Menghapus data sesi.
     */
    public function destroy($id)
    {
        $sesi = Sesi::findOrFail($id);
        $sesi->delete();

        return response()->json([
            'message' => 'Sesi berhasil dihapus.'
        ]);
    }
}
