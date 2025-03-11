<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pemasukan extends Model
{
    protected $table = 'pemasukan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sumber',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
