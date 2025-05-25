<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'reservasi_fasilitas_id',
        'jenis',
        'metode_pembayaran',
        'jumlah_pembayaran',
        'bukti_transfer',
        'status',
    ];

    // Cast tipe data
    protected $casts = [
        'jumlah' => 'double',
        'tanggal_reservasi' => 'date',
        'tanggal_pembayaran' => 'date',
    ];



    /**
     * Relasi ke tabel reservasi_fasilitas
     */
    public function reservasi()
    {
        return $this->belongsTo(ReservasiFasilitas::class, 'reservasi_fasilitas_id');
    }
}
