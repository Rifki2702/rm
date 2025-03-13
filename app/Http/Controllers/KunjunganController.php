<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KunjunganPoliGigi;
use App\Models\KunjunganPoliUmum;
use App\Models\KunjunganRawatInap;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function showKunjunganUmum($pasien_id)
    {
        $dokters = Dokter::all(); // Asumsi Anda memiliki model Dokter
        return view('pasien.kunjungan-poli-umum', compact('pasien_id', 'dokters'));
    }

    public function storeKunjunganUmum(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'jenis_pasien' => 'required|in:Baru,Lama',
            'diagnosis' => 'required|string',
            'pembiayaan' => 'required|in:BPJS,Umum',
            'dokter_id' => 'required|exists:dokter,id',
        ]);

        // Simpan data kunjungan
        KunjunganPoliUmum::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jenis_pasien' => $request->jenis_pasien,
            'diagnosis' => $request->diagnosis,
            'pembiayaan' => $request->pembiayaan,
            'dokter_id' => $request->dokter_id,
        ]);

        return redirect()->route('poli-umum')->with('success', 'Kunjungan poli umum berhasil disimpan!');
    }

    public function showKunjunganGigi($pasien_id)
    {
        $dokters = Dokter::all(); // Asumsi Anda memiliki model Dokter
        return view('pasien.kunjungan-poli-gigi', compact('pasien_id', 'dokters'));
    }

    public function storeKunjunganGigi(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'jenis_pasien' => 'required|in:Baru,Lama',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'pembiayaan' => 'required|in:BPJS,Umum',
            'jasa' => 'required|integer', // Assuming 'jasa' should be an integer
            'dokter_id' => 'required|exists:dokter,id',
        ]);

        // Simpan data kunjungan
        KunjunganPoliGigi::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jenis_pasien' => $request->jenis_pasien,
            'diagnosis' => $request->diagnosis,
            'tindakan' => $request->tindakan,
            'pembiayaan' => $request->pembiayaan,
            'jasa' => $request->jasa,
            'dokter_id' => $request->dokter_id,
        ]);

        return redirect()->route('poli-gigi')->with('success', 'Kunjungan poli gigi berhasil disimpan!');
    }

    public function showKunjunganInap($pasien_id)
    {
        $dokters = Dokter::all(); // Asumsi Anda memiliki model Dokter
        return view('pasien.kunjungan-inap', compact('pasien_id', 'dokters'));
    } // Menampilkan form tambah kunjungan rawat inap

    // Menyimpan data kunjungan rawat inap
    public function storeKunjunganInap(Request $request)
    {
        // Validasi input
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'jenis_pasien' => 'required|in:Baru,Lama',
            'diagnosis' => 'required|string',
            'dokter_ugd_id' => 'required|exists:dokter,id',
            'kondisi_keluar' => 'nullable|in:Sembuh,Rujuk,Pulang Paksa',
            'jenis_pembiayaan' => 'required|in:BPJS,Umum',
            'ruang' => 'required|string',
            'dokter_rawat_inap' => 'required|array', // Dokter rawat inap (bisa lebih dari satu)
            'dokter_rawat_inap.*' => 'exists:dokter,id', // Pastikan setiap dokter yang dipilih valid
            'jumlah' => 'required|array', // Jumlah kunjungan untuk setiap dokter
            'jumlah.*' => 'required|integer|min:1', // Pastikan setiap jumlah valid
        ]);

        // Simpan data kunjungan rawat inap
        $kunjungan = KunjunganRawatInap::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jenis_pasien' => $request->jenis_pasien,
            'diagnosis' => $request->diagnosis,
            'dokter_ugd_id' => $request->dokter_ugd_id,
            'kondisi_keluar' => $request->kondisi_keluar,
            'jenis_pembiayaan' => $request->jenis_pembiayaan,
            'ruang' => $request->ruang,
        ]);

        // Simpan relasi many-to-many dengan dokter rawat inap dan jumlah
        foreach ($request->dokter_rawat_inap as $index => $dokterId) {
            $kunjungan->dokterRawatInap()->attach($dokterId, ['jumlah' => $request->jumlah[$index]]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('rawat-inap')->with('success', 'Data kunjungan rawat inap berhasil disimpan!');
    }
}
