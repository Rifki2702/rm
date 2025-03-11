<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $fillable = ['distributor_id', 'kode_obat', 'nama_obat', 'harga', 'jumlah_stok', 'lokasi_stok', 'tanggal_faktur', 'tanggal_expired'];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
