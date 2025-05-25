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
        $data = Keuangan::latest()->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:infaq,sedekah,donasi,zakat,wakaf,dana kegiatan,reservasi',
            'deskripsi' => 'nullable|string',
            'total_masuk' => 'nullable|numeric|min:0',
            'total_keluar' => 'nullable|numeric|min:0',
        ]);

        // Validasi custom: minimal salah satu harus diisi
        if (empty($validated['total_masuk']) && empty($validated['total_keluar'])) {
            throw ValidationException::withMessages([
                'total_masuk' => ['Total masuk atau total keluar harus diisi salah satu.'],
                'total_keluar' => ['Total masuk atau total keluar harus diisi salah satu.'],
            ]);
        }

        $totalMasuk = $validated['total_masuk'] ?? 0;
        $totalKeluar = $validated['total_keluar'] ?? 0;

        $lastEntry = Keuangan::latest()->first();
        $currentDompet = $lastEntry ? $lastEntry->dompet : 0;

        $validated['total_masuk'] = $totalMasuk;
        $validated['total_keluar'] = $totalKeluar;
        $validated['dompet'] = $currentDompet + $totalMasuk - $totalKeluar;

        $keuangan = Keuangan::create($validated);

        return response()->json([
            'message' => 'Data keuangan berhasil ditambahkan.',
            'data' => $keuangan,
        ], 201);
    }

    public function show(string $id)
    {
        $data = Keuangan::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:infaq,sedekah,donasi,zakat,wakaf,dana kegiatan,reservasi',
            'deskripsi' => 'nullable|string',
            'total_masuk' => 'nullable|numeric|min:0',
            'total_keluar' => 'nullable|numeric|min:0',
        ]);

        // Validasi custom: minimal salah satu harus diisi
        if (empty($validated['total_masuk']) && empty($validated['total_keluar'])) {
            throw ValidationException::withMessages([
                'total_masuk' => ['Total masuk atau total keluar harus diisi salah satu.'],
                'total_keluar' => ['Total masuk atau total keluar harus diisi salah satu.'],
            ]);
        }

        $keuangan = Keuangan::findOrFail($id);

        // Cek hanya entri terakhir yang boleh update
        $lastEntry = Keuangan::latest()->first();
        if ($keuangan->id !== $lastEntry->id) {
            return response()->json([
                'message' => 'Hanya entri terakhir yang dapat diperbarui untuk menjaga konsistensi dompet.'
            ], 400);
        }

        // Hitung dompet berdasarkan entri sebelumnya
        $previousEntry = Keuangan::where('id', '<', $keuangan->id)->latest()->first();
        $currentDompet = $previousEntry ? $previousEntry->dompet : 0;

        $totalMasuk = $validated['total_masuk'] ?? 0;
        $totalKeluar = $validated['total_keluar'] ?? 0;

        $validated['total_masuk'] = $totalMasuk;
        $validated['total_keluar'] = $totalKeluar;
        $validated['dompet'] = $currentDompet + $totalMasuk - $totalKeluar;

        $keuangan->update($validated);

        return response()->json([
            'message' => 'Data keuangan berhasil diperbarui.',
            'data' => $keuangan,
        ]);
    }

    public function destroy(string $id)
    {
        $keuangan = Keuangan::findOrFail($id);

        // Cegah hapus selain entri terakhir
        $lastEntry = Keuangan::latest()->first();
        if ($keuangan->id !== $lastEntry->id) {
            return response()->json([
                'message' => 'Hanya entri terakhir yang dapat dihapus untuk menjaga konsistensi dompet.'
            ], 400);
        }

        $keuangan->delete();

        return response()->json([
            'message' => 'Data keuangan berhasil dihapus.',
        ]);
    }
}
