<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $fillable = ['pasien_id', 'tanggal_kunjungan', 'keterangan'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
