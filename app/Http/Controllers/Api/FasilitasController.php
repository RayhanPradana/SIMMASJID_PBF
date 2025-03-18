<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;


class FasilitasController extends Controller
{
    public function index()
    {
        return Fasilitas::all();
    }

    public function store(Request $request)
    {
        $fasilitas = Fasilitas::create($request->all());
        return response()->json($fasilitas, 201);
    }

    public function show(Fasilitas $fasilitas)
    {
        return Fasilitas::find($fasilitas);
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $fasilitas->update($request->all());
        return Fasilitas::find($fasilitas);
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
