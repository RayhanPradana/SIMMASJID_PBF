<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiFasilitas extends Model
{
    use HasFactory;

    protected $table = 'reservasi_fasilitas';

    protected $fillable = [
        'acara_id',
        'fasilitas_id',
        'user_id',
        'tgl_reservasi',
        'status_reservasi',
        'harga', 
    ];

    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    public function sesi()
    {
        return $this->belongsToMany(Sesi::class, 'reservasi_fasilitas_sesi');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id');
    }
}
