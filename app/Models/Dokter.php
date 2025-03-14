<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'nama',
        'poli',
    ];

    public function kunjunganPoliUmum()
    {
        return $this->hasMany(KunjunganPoliUmum::class, 'dokter_id');
    }

    public function kunjunganPoliGigi()
    {
        return $this->hasMany(KunjunganPoliGigi::class, 'dokter_id');
    }

    public function kunjunganRawatInap()
    {
        return $this->belongsToMany(KunjunganRawatInap::class, 'dokter_kunjungan_rawat_inap', 'dokter_id', 'kunjungan_rawat_inap_id');
    }
}
