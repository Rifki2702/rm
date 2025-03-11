<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $fillable = [
        'no_rm',
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public function kunjunganPoliUmum()
    {
        return $this->hasMany(KunjunganPoliUmum::class, 'pasien_id');
    }
}
