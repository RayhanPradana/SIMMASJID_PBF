<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReservasiFasilitas;
use App\Models\Acara;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ReservasiController extends Controller
{
    // Menampilkan semua reservasi milik user yang login
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            $reservasi = ReservasiFasilitas::with(['acara', 'fasilitas', 'sesi', 'user'])->get();
        } else {
            $reservasi = ReservasiFasilitas::where('user_id', $user->id)
                ->with(['acara', 'fasilitas', 'sesi'])
                ->get();
        }

        return response()->json($reservasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'acara_id' => 'required|exists:acara,id',
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tgl_reservasi' => 'required|date',
            'sesi_id' => 'required|array',
            'sesi_id.*' => 'exists:sesi,id',
            'user_id' => 'nullable|exists:users,id', // hanya dipakai admin
        ]);

        $user = Auth::user();
        $userId = $user->role === 'admin' && $request->filled('user_id')
            ? $request->user_id
            : $user->id;

        // Cek bentrok sesi
        foreach ($request->sesi_id as $sesi) {
            $bentrok = ReservasiFasilitas::where('tgl_reservasi', $request->tgl_reservasi)
                ->where('fasilitas_id', $request->fasilitas_id)
                ->whereHas('sesi', fn($q) => $q->where('sesi.id', $sesi))
                ->exists();
            if ($bentrok) {
                return response()->json(['message' => "Sesi $sesi sudah dipesan pada tanggal tersebut."], 422);
            }
        }

        // Ambil harga dari acara dan fasilitas
        $acara = Acara::findOrFail($request->acara_id);
        $fasilitas = Fasilitas::findOrFail($request->fasilitas_id);
        $totalHarga = $acara->harga + $fasilitas->harga;

        $reservasi = ReservasiFasilitas::create([
            'acara_id' => $request->acara_id,
            'fasilitas_id' => $request->fasilitas_id,
            'tgl_reservasi' => $request->tgl_reservasi,
            'status_reservasi' => 'pending',
            'user_id' => $userId,
            'harga' => $totalHarga,
        ]);

        $reservasi->sesi()->attach($request->sesi_id);

        return response()->json([
            'message' => 'Reservasi berhasil dibuat',
            'data' => $reservasi->load('sesi')
        ], 201);
    }

    public function show($id)
    {
        $reservasi = ReservasiFasilitas::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['acara', 'fasilitas', 'sesi'])
            ->firstOrFail();

        return response()->json($reservasi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_reservasi' => 'required|date',
            'sesi_id' => 'required|array',
            'sesi_id.*' => 'exists:sesi,id',
            'status_reservasi' => 'nullable|string|in:disetujui,ditolak,menunggu lunas,siap digunakan,sedang berlangsung,dibatalkan,selesai',
        ]);

        $user = Auth::user();

        $reservasi = $user->role === 'admin'
            ? ReservasiFasilitas::findOrFail($id)
            : ReservasiFasilitas::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        foreach ($request->sesi_id as $sesi) {
            $bentrok = ReservasiFasilitas::where('tgl_reservasi', $request->tgl_reservasi)
                ->where('fasilitas_id', $reservasi->fasilitas_id)
                ->where('id', '!=', $reservasi->id)
                ->whereHas('sesi', fn($q) => $q->where('sesi.id', $sesi))
                ->exists();

            if ($bentrok) {
                return response()->json(['message' => "Sesi $sesi sudah dipesan pada tanggal tersebut."], 422);
            }
        }

        $reservasi->tgl_reservasi = $request->tgl_reservasi;

        if ($user->role === 'admin' && $request->has('status_reservasi')) {
            $reservasi->status_reservasi = $request->status_reservasi;
        }

        $reservasi->save();
        $reservasi->sesi()->sync($request->sesi_id);

        return response()->json([
            'message' => 'Reservasi berhasil diperbarui',
            'data' => $reservasi->load('sesi')
        ]);
    }

    public function destroy($id)
    {
        $reservasi = ReservasiFasilitas::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reservasi->delete();

        return response()->json(['message' => 'Reservasi berhasil dihapus']);
    }

    public function confirm(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:disetujui,ditolak,menunggu lunas,siap digunakan,sedang berlangsung,dibatalkan,selesai',
        ]);

        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Only admin can confirm reservations.'], 403);
        }

        $reservasi = ReservasiFasilitas::findOrFail($id);
        $reservasi->status_reservasi = $request->status;
        $reservasi->save();

        return response()->json([
            'message' => "Reservasi berhasil diperbarui menjadi: {$request->status}",
            'data' => $reservasi->load(['acara', 'fasilitas', 'sesi', 'user'])
        ]);
    }

    private function updateStatusOtomatis($reservasiCollection)
    {
        $now = Carbon::now();
        $today = Carbon::today();

        foreach ($reservasiCollection as $reservasi) {
            // Skip jika status sudah final (selesai, dibatalkan, ditolak)
            if (in_array($reservasi->status_reservasi, ['selesai', 'dibatalkan', 'ditolak'])) {
                continue;
            }

            $tanggalReservasi = Carbon::parse($reservasi->tgl_reservasi);

            // Skip jika reservasi belum disetujui atau belum siap digunakan
            if (!in_array($reservasi->status_reservasi, ['siap digunakan', 'sedang berlangsung'])) {
                continue;
            }

            // Ambil semua sesi untuk reservasi ini
            $sesiList = $reservasi->sesi;

            if ($sesiList->isEmpty()) {
                continue;
            }

            // Cari sesi yang paling awal dan paling akhir
            $waktuMulaiTerAwal = null;
            $waktuSelesaiTerAkhir = null;

            foreach ($sesiList as $sesi) {
                $waktuMulai = Carbon::parse($tanggalReservasi->format('Y-m-d') . ' ' . $sesi->waktu_mulai);
                $waktuSelesai = Carbon::parse($tanggalReservasi->format('Y-m-d') . ' ' . $sesi->waktu_selesai);

                if ($waktuMulaiTerAwal === null || $waktuMulai->lt($waktuMulaiTerAwal)) {
                    $waktuMulaiTerAwal = $waktuMulai;
                }

                if ($waktuSelesaiTerAkhir === null || $waktuSelesai->gt($waktuSelesaiTerAkhir)) {
                    $waktuSelesaiTerAkhir = $waktuSelesai;
                }
            }

            // Logika update status
            if ($waktuSelesaiTerAkhir && $now->gt($waktuSelesaiTerAkhir)) {
                // Jika sudah melewati waktu selesai sesi terakhir -> status "selesai"
                if ($reservasi->status_reservasi !== 'selesai') {
                    $reservasi->status_reservasi = 'selesai';
                    $reservasi->save();
                }
            } elseif ($waktuMulaiTerAwal && $now->gte($waktuMulaiTerAwal) && $now->lte($waktuSelesaiTerAkhir)) {
                // Jika waktu sekarang di antara sesi pertama dan terakhir -> status "sedang berlangsung"
                if ($reservasi->status_reservasi !== 'sedang berlangsung') {
                    $reservasi->status_reservasi = 'sedang berlangsung';
                    $reservasi->save();
                }
            }
            // Jika belum sampai waktu mulai, tetap "siap digunakan"
        }
    }

    /**
     * Endpoint khusus untuk menjalankan update status otomatis (bisa dipanggil via cron job)
     */
    public function updateAllStatusOtomatis()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Only admin can run this operation.'], 403);
        }

        $reservasi = ReservasiFasilitas::with(['sesi'])
            ->whereNotIn('status_reservasi', ['selesai', 'dibatalkan', 'ditolak'])
            ->get();

        $this->updateStatusOtomatis($reservasi);

        return response()->json([
            'message' => 'Status reservasi berhasil diperbarui secara otomatis',
            'total_processed' => $reservasi->count()
        ]);
    }
}
