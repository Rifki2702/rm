<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('alamat');
            $table->string('telp');
            $table->string('lokasi_penjualan')->default('Farmasi RJ');
            $table->string('nama_dokter');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
};
