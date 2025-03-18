<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_fasilitas',
        'keterangan',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
