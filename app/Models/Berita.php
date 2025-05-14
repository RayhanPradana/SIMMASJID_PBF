<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'tanggal',
        'status',
    ];

    // public function setTanggalAttribute($value)
    // {
    //     $this->attributes['tanggal'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    // }

    // public function getTanggalAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d-m-Y');
    // }
    
    // public function getJWTIdentifier(){
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims(){
    //     return [];
    // }
}
