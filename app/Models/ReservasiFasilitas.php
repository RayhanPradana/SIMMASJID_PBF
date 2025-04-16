<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReservasiFasilitas extends Model
{
    protected $table = 'reservasi_fasilitas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'fasilitas_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }

    // Setter: Konversi format input tanggal ke format MySQL (YYYY-MM-DD)
    public function setTanggalMulaiAttribute($value)
    {
        $this->attributes['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function setTanggalSelesaiAttribute($value)
    {
        $this->attributes['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Getter: Konversi format tanggal untuk ditampilkan ke user (DD-MM-YYYY)
    public function getTanggalMulaiAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getTanggalSelesaiAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    // Getter: Format waktu (HH:MM)
    public function getWaktuMulaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getWaktuSelesaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
