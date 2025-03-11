<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjunganTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->enum('jenis_pasien', ['BARU', 'LAMA']);
            $table->text('diagnosa');
            $table->string('dokter', 100);
            $table->enum('jenis_pembiayaan', ['BPJS', 'UMUM', 'BKKBN']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
}
