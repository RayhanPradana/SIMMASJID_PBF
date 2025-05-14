<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservasiFasilitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

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

    /**
     * Cek ketersediaan fasilitas pada waktu tertentu
     */
    private function checkAvailability($fasilitas_id, $tgl_reservasi, $jam_mulai, $jam_selesai, $excludeId = null)
    {
        $query = ReservasiFasilitas::where('fasilitas_id', $fasilitas_id)
            ->where('tgl_reservasi', $tgl_reservasi)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                // Cek jika ada reservasi yang overlap dengan waktu yang diminta
                // Case 1: Jadwal baru mulai di tengah jadwal yang sudah ada
                $query->where(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '<=', $jam_mulai)
                      ->where('jam_selesai', '>', $jam_mulai);
                })
                // Case 2: Jadwal baru selesai di tengah jadwal yang sudah ada
                ->orWhere(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '<', $jam_selesai)
                      ->where('jam_selesai', '>=', $jam_selesai);
                })
                // Case 3: Jadwal baru sepenuhnya di dalam jadwal yang sudah ada
                ->orWhere(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '>=', $jam_mulai)
                      ->where('jam_selesai', '<=', $jam_selesai);
                })
                // Case 4: Jadwal baru sepenuhnya mencakup jadwal yang sudah ada
                ->orWhere(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '<=', $jam_mulai)
                      ->where('jam_selesai', '>=', $jam_selesai);
                });
            });

        // Exclude current reservation when updating
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'fasilitas_id' => 'required|integer|exists:fasilitas,id',
                'acara_id' => 'required|integer|exists:acara,id',
                'tgl_reservasi' => 'required|date',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'tgl_pembayaran' => 'nullable|date',
                'status_pembayaran' => 'required|string|in:unpaid,paid',
            ]);

            // Default to 'unpaid' if not set
            if (!isset($validatedData['status_pembayaran'])) {
                $validatedData['status_pembayaran'] = 'unpaid';
            }

            // Cek apakah fasilitas tersedia pada waktu yang diminta
            $isBooked = $this->checkAvailability(
                $validatedData['fasilitas_id'],
                $validatedData['tgl_reservasi'],
                $validatedData['jam_mulai'],
                $validatedData['jam_selesai']
            );

            if ($isBooked) {
                throw ValidationException::withMessages([
                    'jam_mulai' => ['Fasilitas sudah dipesan pada jam tersebut. Silakan pilih waktu lain.']
                ]);
            }

            $reservasi = ReservasiFasilitas::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Dibuat',
                'data' => $reservasi
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
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
                'acara_id' => 'sometimes|integer|exists:acara,id',
                'tgl_reservasi' => 'sometimes|date',
                'jam_mulai' => 'sometimes|date_format:H:i',
                'jam_selesai' => 'sometimes|date_format:H:i|after:jam_mulai',
                'tgl_pembayaran' => 'nullable|date',
                'status_pembayaran' => 'sometimes|string|in:unpaid,paid',
            ]);

            // Jika ada perubahan pada fasilitas, tanggal, atau jam
            if (isset($validatedData['fasilitas_id']) ||
                isset($validatedData['tgl_reservasi']) ||
                isset($validatedData['jam_mulai']) ||
                isset($validatedData['jam_selesai'])) {

                // Gunakan nilai yang ada jika tidak diupdate
                $fasilitas_id = $validatedData['fasilitas_id'] ?? $reservasi->fasilitas_id;
                $tgl_reservasi = $validatedData['tgl_reservasi'] ?? $reservasi->tgl_reservasi;
                $jam_mulai = $validatedData['jam_mulai'] ?? $reservasi->jam_mulai;
                $jam_selesai = $validatedData['jam_selesai'] ?? $reservasi->jam_selesai;

                // Cek ketersediaan dengan pengecualian ID saat ini
                $isBooked = $this->checkAvailability(
                    $fasilitas_id,
                    $tgl_reservasi,
                    $jam_mulai,
                    $jam_selesai,
                    $id // Exclude current reservation
                );

                if ($isBooked) {
                    throw ValidationException::withMessages([
                        'jam_mulai' => ['Fasilitas sudah dipesan pada jam tersebut. Silakan pilih waktu lain.']
                    ]);
                }
            }

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
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
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

    public function checkFasilitasAvailability(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fasilitas_id' => 'required|integer|exists:fasilitas,id',
                'tgl_reservasi' => 'required|date',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);

            $isBooked = $this->checkAvailability(
                $validatedData['fasilitas_id'],
                $validatedData['tgl_reservasi'],
                $validatedData['jam_mulai'],
                $validatedData['jam_selesai']
            );

            return response()->json([
                'success' => true,
                'available' => !$isBooked,
                'message' => $isBooked ?
                    'Fasilitas tidak tersedia pada waktu yang dipilih' :
                    'Fasilitas tersedia pada waktu yang dipilih'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
