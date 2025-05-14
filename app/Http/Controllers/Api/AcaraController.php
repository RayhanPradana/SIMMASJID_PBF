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
            'id' => 'nullable|string|max:50|unique:acaras,id', // Validasi untuk ID kustom
        ], [
            'nama_acara.required' => 'Nama acara wajib diisi.',
            'nama_acara.string' => 'Nama acara harus berupa teks.',
            'nama_acara.max' => 'Nama acara maksimal 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'id.unique' => 'ID acara sudah digunakan.',
            'id.string' => 'ID acara harus berupa teks.',
            'id.max' => 'ID acara maksimal 50 karakter.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Membuat data untuk disimpan
        $data = $request->only(['nama_acara', 'deskripsi']);

        // Jika ID diberikan dari frontend, gunakan ID tersebut
        if ($request->has('id')) {
            $data['id'] = $request->id;
        } else {
            // Jika tidak ada ID dari frontend, generate ID dengan format AC-{angka}
            $latestAcara = Acara::orderBy('id', 'desc')->first();

            if ($latestAcara) {
                // Coba ekstrak nomor dari ID yang sudah ada (jika formatnya AC-123)
                $matches = [];
                if (preg_match('/AC-(\d+)/', $latestAcara->id, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                } else {
                    // Jika format tidak sesuai, mulai dari 1
                    $nextNumber = 1;
                }
            } else {
                // Jika belum ada data sama sekali
                $nextNumber = 1;
            }

            $data['id'] = 'AC-' . $nextNumber;
        }

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
        ], [
            'nama_acara.string' => 'Nama acara harus berupa teks.',
            'nama_acara.max' => 'Nama acara maksimal 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data
        $acara->update($request->only(['nama_acara', 'deskripsi']));

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


