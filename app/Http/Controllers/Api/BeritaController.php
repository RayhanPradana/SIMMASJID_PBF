<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BeritaController extends Controller
{
    public function index()
    {
        try {
            $berita = Berita::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Berita Berhasil Diambil',
                'data' => $berita
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
                'judul' => 'required|string|max:255|unique:beritas,judul',
                'konten' => 'required|string',
                'kategori' => 'required|string|max:100',
                'penulis' => 'required|string|max:100',
            ]);

            $berita = Berita::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Berita Berhasil Dibuat',
                'data' => $berita
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
            $berita = Berita::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Berita Ditemukan',
                'data' => $berita
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
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
            $berita = Berita::findOrFail($id);

            $validatedData = $request->validate([
                'judul' => ['sometimes', 'string', 'max:255', Rule::unique('beritas', 'judul')->ignore($id)],
                'konten' => 'sometimes|string',
                'kategori' => 'sometimes|string|max:100',
                'penulis' => 'sometimes|string|max:100',
            ]);

            $berita->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Berita Berhasil Diperbarui',
                'data' => $berita
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
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
            $berita = Berita::findOrFail($id);
            $berita->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berita Berhasil Dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
