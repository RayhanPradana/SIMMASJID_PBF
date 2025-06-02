<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Container\Attributes\DB;
use Illuminate\Validation\Rule;
use App\Models\ReservasiFasilitas;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('reservasi')->get();
        return response()->json($pembayaran);
    }


    public function store(Request $request)
    {
        $request->validate([
            'reservasi_fasilitas_id' => 'required|exists:reservasi_fasilitas,id',
            'jenis' => 'required|in:dp,pelunasan,lunas',
            'metode_pembayaran' => 'required|in:transfer,tunai,lainnya',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload bukti transfer jika ada
        $buktiPath = $request->hasFile('bukti_transfer')
            ? $request->file('bukti_transfer')->store('bukti_transfer', 'public')
            : null;

        // Tentukan status berdasarkan jenis pembayaran
        $status = match ($request->jenis) {
            'dp' => 'belum lunas',
            'lunas' => 'paid',
            'pelunasan' => 'paid',
            default => 'pending'
        };

        // Simpan data ke database
        $pembayaran = Pembayaran::create([
            'reservasi_fasilitas_id' => $request->reservasi_fasilitas_id,
            'jenis' => $request->jenis,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'bukti_transfer' => $buktiPath,
            'status' => $status,
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil dikirim dan sedang diproses.',
            'data' => $pembayaran
        ], 201);
    }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $pembayaran = Pembayaran::with('reservasi')->findOrFail($id);
        $pembayaran->bukti_transfer_url = $pembayaran->bukti_transfer
            ? asset('storage/' . $pembayaran->bukti_transfer)
            : null;

        return response()->json($pembayaran);
    }

    // Update status pembayaran (paid/unpaid/pending)
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,belum lunas,paid,unpaid',
        ]);

        $pembayaran->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
            'data' => $pembayaran
        ]);
    }

    // Menghapus pembayaran dan file bukti transfer
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // Hapus file jika ada
        if ($pembayaran->bukti_transfer) {
            Storage::disk('public')->delete($pembayaran->bukti_transfer);
        }

        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran berhasil dihapus.']);
    }
}
