<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_details'; // Nama tabel di database
    protected $fillable = ['penjualan_id', 'obat_id', 'jumlah', 'total_harga']; // Kolom yang bisa diisi secara massal

    // Relasi ke tabel obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    // Relasi ke tabel penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
