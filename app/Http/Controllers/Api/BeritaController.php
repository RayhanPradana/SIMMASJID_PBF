<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
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

        //dd($request->all());  

        $validatedData = Validator::make($request->all(), [
            'judul' => 'required|string|max:255|unique:berita,judul',
            'konten' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'status' => 'required|in:Draft,Publikasi',
        ]);

        $gambar = $request->file('gambar');
        $gambarPath = null;

        if ($gambar) {
            $gambarPath = $gambar->store('images', 'public');
        }

        if ($validatedData->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
            ], 422);
        }


        $berita = Berita::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'tanggal' => $request->tanggal,
            'gambar' => $gambarPath,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita Berhasil Dibuat',
            'data' => $berita
        ], 201);
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
                'judul' => 'required|string|max:255|unique:berita,judul,' . $id,
                'konten' => 'required|string',
                'tanggal' => 'required|date',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'status' => 'required|in:Draft,Publikasi',
            ]);

            if ($request->hasFile('gambar')) {
                if ($berita->gambar) {
                    Storage::disk('public')->delete(paths: 'images/' . $berita->gambar);
                }

                $imageName = 'images/' . basename($request->file('gambar')->store('images', 'public'));
            } else {
                $imageName = $berita->gambar;
            }

            $berita->update([
                'judul' => $request->judul ?? $berita->judul,
                'konten' => $request->konten ?? $berita->konten,
                'tanggal' => $request->tanggal ?? $berita->tanggal,
                'gambar' => $imageName,
                'status' => $request->status ?? $berita->status,
            ]);

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
