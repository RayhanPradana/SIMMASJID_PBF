<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;


class JadwalController extends Controller
{
    public function index()
    {
        return Jadwal::all();
    }

    public function store(Request $request)
    {
        $jadwal = Jadwal::create($request->all());
        return response()->json($jadwal, 201);
    }

    public function show(Jadwal $jadwal)
    {
        return jadwal::find($jadwal);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $jadwal->update($request->all());
        return Jadwal::find($jadwal);
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}
