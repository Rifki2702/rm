<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan_poli_umum', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->unsignedBigInteger('pasien_id'); // Foreign key ke tabel pasien
            $table->date('tanggal_kunjungan'); // Tanggal kunjungan
            $table->enum('jenis_pasien', ['Baru', 'Lama']); // Jenis pasien (Baru/Lama)
            $table->text('diagnosis'); // Diagnosis pasien
            $table->enum('pembiayaan', ['BPJS', 'Umum']); // Jenis pembiayaan (BPJS/Umum)
            $table->unsignedBigInteger('dokter_id'); // Foreign key ke tabel dokter
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_poli_umum');
    }
};
