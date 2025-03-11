<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained('distributors')->onDelete('cascade');
            $table->string('kode_obat')->unique();
            $table->string('nama_obat');
            $table->decimal('harga', 10, 2);
            $table->integer('jumlah_stok');
            $table->string('lokasi_stok');
            $table->dateTime('tanggal_faktur')->default(now());
            $table->date('tanggal_expired');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obat');
    }
};
