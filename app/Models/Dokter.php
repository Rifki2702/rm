<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'nama', 'poli',
    ];

    public function kunjunganPoliUmum()
    {
        return $this->hasMany(KunjunganPoliUmum::class, 'dokter_id');
    }
}
