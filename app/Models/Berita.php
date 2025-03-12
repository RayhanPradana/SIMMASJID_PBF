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
    ];

     
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
