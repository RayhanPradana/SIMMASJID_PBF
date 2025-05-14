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
        'acara_id',
        'tgl_reservasi',
        'jam_mulai',
        'jam_selesai',
        'tgl_pembayaran',
        'status_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }

    // Cast tipe data
    protected $casts = [
        'tgl_reservasi' => 'date',
        'tgl_pembayaran' => 'date',
        'status_pembayaran' => 'string',
    ];

    /**
     * Get the tgl_reservasi attribute in d-m-Y format.
     *
     * @param  string  $value
     * @return string
     */
    public function getTglReservasiAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }

    /**
     * Set the tgl_reservasi attribute from d-m-Y format to Y-m-d.
     *
     * @param  string  $value
     * @return void
     */
    public function setTglReservasiAttribute($value)
    {
        if ($value) {
            // Check if value is already in proper format
            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $value)) {
                $this->attributes['tgl_reservasi'] = Carbon::createFromFormat('d-m-Y', $value);
            } else {
                $this->attributes['tgl_reservasi'] = $value;
            }
        } else {
            $this->attributes['tgl_reservasi'] = null;
        }
    }

    /**
     * Get the tgl_pembayaran attribute in d-m-Y format.
     *
     * @param  string  $value
     * @return string
     */
    public function getTglPembayaranAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }

    /**
     * Set the tgl_pembayaran attribute from d-m-Y format to Y-m-d.
     *
     * @param  string  $value
     * @return void
     */
    public function setTglPembayaranAttribute($value)
    {
        if ($value) {
            // Check if value is already in proper format
            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $value)) {
                $this->attributes['tgl_pembayaran'] = Carbon::createFromFormat('d-m-Y', $value);
            } else {
                $this->attributes['tgl_pembayaran'] = $value;
            }
        } else {
            $this->attributes['tgl_pembayaran'] = null;
        }
    }

    // Getter: Format waktu (HH:MM)
    public function getJamMulaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getJamSelesaiAttribute($value)
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
