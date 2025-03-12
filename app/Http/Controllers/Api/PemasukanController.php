<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasukan;

class PemasukanController extends Controller
{
    public function index()
    {
        return Pemasukan::all();
    }

    public function store(Request $request)
    {
        $pemasukan = Pemasukan::create($request->all());
        return response()->json($pemasukan, 201);
    }

    public function show(Pemasukan $pemasukan)
    {
        return Pemasukan::find($pemasukan);
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $pemasukan->update($request->all());
        return Pemasukan::find($pemasukan);
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
