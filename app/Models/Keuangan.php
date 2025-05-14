<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Keuangan extends Model
{
    use HasFactory;
    
    // Nama tabel jika berbeda dari konvensi
    protected $table = 'keuangan';
    
    // Daftar kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'jenis',
        'jumlah',
        'sumber',
        'deskripsi',
        'tanggal'
    ];
    
    // Cast tipe data
    protected $casts = [
        'jumlah' => 'double',
        'tanggal' => 'date',
    ];
    
    /**
     * Get the tanggal attribute in d-m-Y format.
     *
     * @param  string  $value
     * @return string
     */
    public function getTanggalAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }
    
    /**
     * Set the tanggal attribute from d-m-Y format to Y-m-d.
     *
     * @param  string  $value
     * @return void
     */
    public function setTanggalAttribute($value)
    {
        if ($value) {
            // Check if value is already in proper format
            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $value)) {
                $this->attributes['tanggal'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            } else {
                $this->attributes['tanggal'] = $value;
            }
        } else {
            $this->attributes['tanggal'] = null;
        }
    }
}