<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokterKunjunganRawatInapTable extends Migration
{
    public function up()
    {
        Schema::create('dokter_kunjungan_rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunjungan_rawat_inap_id'); // Relasi ke tabel kunjungan_rawat_inap
            $table->unsignedBigInteger('dokter_id'); // Relasi ke tabel dokter
            $table->integer('jumlah'); // Menambahkan kolom jumlah
            $table->timestamps(); // created_at dan updated_at

            // Foreign key untuk kunjungan_rawat_inap_id
            $table->foreign('kunjungan_rawat_inap_id')->references('id')->on('kunjungan_rawat_inap')->onDelete('cascade');

            // Foreign key untuk dokter_id
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokter_kunjungan_rawat_inap');
    }
}
