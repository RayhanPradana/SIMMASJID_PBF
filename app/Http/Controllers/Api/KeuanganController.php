<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;

class KeuanganController extends Controller
{
    public function index()
    {
        return Keuangan::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'sumber' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $keuangan = Keuangan::create($data);
        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $keuangan], 201);
    }

    public function show($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return response()->json($keuangan);
    }

    public function update(Request $request, $id)
{
    $keuangan = Keuangan::findOrFail($id);

    // Pastikan data berasal dari body request, bukan query parameter
    $data = $request->only(['jenis', 'jumlah', 'sumber', 'deskripsi', 'tanggal']);

    if (empty($data)) {
        return response()->json(['message' => 'Data tidak ditemukan dalam request'], 400);
    }

    $keuangan->update($data);
    return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $keuangan]);
}


    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
