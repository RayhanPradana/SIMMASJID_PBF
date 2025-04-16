<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kegiatan',
        'hari',
        'waktu',
        'tempat',
        'penanggung_jawab',
        'keterangan',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
