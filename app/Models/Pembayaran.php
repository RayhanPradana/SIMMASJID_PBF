<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'reservasi_id',
        'tanggal_reservasi',
        'tanggal_pembayaran',
        'jumlah',
        'status',
        'bukti_transfer',
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
        return $this->belongsTo(ReservasiFasilitas::class, 'reservasi_id', 'id');
    }

    /**
     * Relasi ke tabel users (jika dibutuhkan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Aksesor tanggal_reservasi format d-m-Y
     */
    public function getTanggalReservasiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    /**
     * Mutator untuk tanggal_reservasi dari d-m-Y ke Y-m-d
     */
    public function setTanggalReservasiAttribute($value)
    {
        if ($value && preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $value)) {
            $this->attributes['tanggal_reservasi'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal_reservasi'] = $value;
        }
    }

    /**
     * Aksesor tanggal_pembayaran format d-m-Y
     */
    public function getTanggalPembayaranAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    /**
     * Mutator untuk tanggal_pembayaran dari d-m-Y ke Y-m-d
     */
    public function setTanggalPembayaranAttribute($value)
    {
        if ($value && preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $value)) {
            $this->attributes['tanggal_pembayaran'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['tanggal_pembayaran'] = $value;
        }
    }
}
