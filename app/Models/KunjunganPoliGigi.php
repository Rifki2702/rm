<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganPoliGigi extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_poli_gigi';
    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'jenis_pasien',
        'diagnosis',
        'tindakan',
        'pembiayaan',
        'jasa',
        'dokter_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
