<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganRawatInap extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_rawat_inap';

    protected $fillable = [
        'pasien_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'jenis_pasien',
        'diagnosis',
        'dokter_ugd_id',
        'kondisi_keluar',
        'ruang',
        'jenis_pembiayaan',
    ];

    // Relasi ke tabel pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Relasi ke tabel dokter (untuk dokter UGD)
    public function dokterUgd()
    {
        return $this->belongsTo(Dokter::class, 'dokter_ugd_id');
    }

    // Relasi many-to-many ke tabel dokter (untuk dokter rawat inap)
    public function dokterRawatInap()
    {
        return $this->belongsToMany(Dokter::class, 'dokter_kunjungan_rawat_inap', 'kunjungan_rawat_inap_id', 'dokter_id')->withPivot('jumlah');
    }
}
