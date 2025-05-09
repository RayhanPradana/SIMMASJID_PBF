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
        'metode_pembayaran',
        'jumlah',
        'status',
        'bukti_transfer',
        'tanggal_pembayaran',
    ];

    public function setTanggalPembayaranAttribute($value)
    {
        $this->attributes['tanggal_pembayaran'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getTanggalPembayaranAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reservasi()
    {
        return $this->belongsTo(ReservasiFasilitas::class, 'reservasi_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
