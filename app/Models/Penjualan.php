<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan'; // Nama tabel di database
    protected $fillable = ['nama_pasien', 'lokasi_penjualan']; // Kolom yang bisa diisi secara massal

    // Relasi ke tabel penjualan_details
    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
