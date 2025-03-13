<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjunganRawatInapTable extends Migration
{
    public function up()
    {
        Schema::create('kunjungan_rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id'); // Relasi ke tabel pasien
            $table->date('tanggal_masuk'); // Tanggal masuk rawat inap
            $table->date('tanggal_keluar')->nullable(); // Tanggal keluar rawat inap (bisa null jika belum keluar)
            $table->enum('jenis_pasien', ['Baru', 'Lama']); // Jenis pasien
            $table->text('diagnosis'); // Diagnosis pasien
            $table->unsignedBigInteger('dokter_ugd_id'); // Dokter UGD (relasi ke tabel dokter)
            $table->enum('kondisi_keluar', ['Sembuh', 'Rujuk', 'Pulang Paksa'])->nullable(); // Kondisi keluar
            $table->enum('jenis_pembiayaan', ['BPJS', 'Umum']); // Jenis pembiayaan
            $table->string('ruang'); // Kolom ruang
            $table->timestamps(); // created_at dan updated_at

            // Foreign key untuk pasien_id
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');

            // Foreign key untuk dokter_ugd_id
            $table->foreign('dokter_ugd_id')->references('id')->on('dokter')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kunjungan_rawat_inap');
    }
}
