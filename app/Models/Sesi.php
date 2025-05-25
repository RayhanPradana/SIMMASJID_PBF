<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi)
    protected $table = 'sesi';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'deskripsi',
    ];

    // Jika ingin menentukan format waktu (opsional)
    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    public function reservasi()
    {
        return $this->belongsToMany(ReservasiFasilitas::class, 'reservasi_fasilitas_sesi');
    }

}
