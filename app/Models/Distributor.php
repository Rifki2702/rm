<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = ['kode_distributor', 'nama'];

    // Method untuk generate kode distributor otomatis
    public static function generateKode()
    {
        $lastDistributor = self::orderBy('kode_distributor', 'desc')->first();
        
        if (!$lastDistributor) {
            return 'HS001';
        }

        // Ambil 3 digit terakhir dari kode dan tambahkan 1
        $lastNumber = intval(substr($lastDistributor->kode_distributor, 2));
        $newNumber = $lastNumber + 1;
        
        // Format number dengan leading zeros
        return 'HS' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Event sebelum menyimpan data baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($distributor) {
            // Generate kode distributor otomatis jika belum diset
            if (!$distributor->kode_distributor) {
                $distributor->kode_distributor = self::generateKode();
            }
        });
    }
} 