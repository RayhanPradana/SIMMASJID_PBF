<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PembayaranController extends Controller
{
    public function index()
    {
        try {
            $pembayaran = Pembayaran::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Pembayaran Berhasil Diambil',
                'data' => $pembayaran
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
                'user_id' => 'required|exists:users,id',
                'reservasi_id' => 'required|exists:reservasi_fasilitas,id',
                'metode_pembayaran' => 'required|string|max:100',
                'jumlah' => 'required|numeric|min:0',
                'status' => 'required|in:pending,sukses,gagal',
                'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanggal_pembayaran' => 'nullable|date_format:D-M-y'
            ]);

            if ($request->hasFile('bukti_transfer')) {
                $validatedData['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            }

            $pembayaran = Pembayaran::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil Dibuat',
                'data' => $pembayaran
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
            $pembayaran = Pembayaran::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Pembayaran Ditemukan',
                'data' => $pembayaran
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
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
            $pembayaran = Pembayaran::findOrFail($id);

            $validatedData = $request->validate([
                'metode_pembayaran' => 'sometimes|string|max:100',
                'jumlah' => 'sometimes|numeric|min:0',
                'status' => 'sometimes|in:pending,sukses,gagal',
                'bukti_transfer' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanggal_pembayaran' => 'sometimes|date_format:Y-m-d'
            ]);

            if ($request->hasFile('bukti_transfer')) {
                $validatedData['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            }

            $pembayaran->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil Diperbarui',
                'data' => $pembayaran
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
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
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil Dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
