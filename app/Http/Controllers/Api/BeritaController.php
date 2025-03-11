<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;


class BeritaController extends Controller
{
    public function index()
    {
        return Berita::all();
    }

    public function store(Request $request)
    {
        $berita = Berita::create($request->all());
        return response()->json($berita, 201);
    }

    public function show(Berita $berita)
    {
        return berita::find($berita);
    }

    public function update(Request $request, Berita $berita)
    {
        $berita->update($request->all());
        return Berita::find($berita);
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
