<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use Illuminate\Validation\ValidationException;

class KeuanganController extends Controller
{
    public function index()
    {
        return Keuangan::all();
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'jenis' => 'required|in:pemasukan,pengeluaran',
                'jumlah' => 'required|numeric|min:0',
                'sumber' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal' => 'required|date',
            ]);

            $keuangan = Keuangan::create($data);
            return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $keuangan], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return response()->json($keuangan);
    }

    public function update(Request $request, $id)
    {
        try {
            $keuangan = Keuangan::findOrFail($id);
            
            // Validasi data input
            $data = $request->validate([
                'jenis' => 'sometimes|required|in:pemasukan,pengeluaran',
                'jumlah' => 'sometimes|required|numeric|min:0',
                'sumber' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal' => 'sometimes|required|date',
            ]);
            
            $keuangan->update($data);
            return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $keuangan]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}