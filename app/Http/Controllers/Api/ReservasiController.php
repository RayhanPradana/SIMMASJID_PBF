<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservasiFasilitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReservasiController extends Controller
{
    public function index()
    {
        try {
            $reservasi = ReservasiFasilitas::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Reservasi Berhasil Diambil',
                'data' => $reservasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'fasilitas_id' => 'required|integer|exists:fasilitas,id',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'required|date_format:H:i',
                'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            ]);

            $validatedData['status'] = 'pending'; // Set status default pending

            $reservasi = ReservasiFasilitas::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Dibuat',
                'data' => $reservasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $reservasi = ReservasiFasilitas::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Reservasi Ditemukan',
                'data' => $reservasi
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reservasi = ReservasiFasilitas::findOrFail($id);

            $validatedData = $request->validate([
                'user_id' => 'sometimes|integer|exists:users,id',
                'fasilitas_id' => 'sometimes|integer|exists:fasilitas,id',
                'tanggal_mulai' => 'sometimes|date',
                'tanggal_selesai' => 'sometimes|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'sometimes|date_format:H:i',
                'waktu_selesai' => 'sometimes|date_format:H:i|after:waktu_mulai',
                'status' => 'sometimes|string|in:pending,approved,rejected',
            ]);

            $reservasi->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Diperbarui',
                'data' => $reservasi
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reservasi = ReservasiFasilitas::findOrFail($id);
            $reservasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
