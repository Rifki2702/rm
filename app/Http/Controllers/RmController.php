<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KunjunganPoliUmum;
use Illuminate\Http\Request;
use App\Models\Pasien;

class RmController extends Controller
{
    public function poliUmum()
    {
        $kunjungan = KunjunganPoliUmum::with(['pasien', 'dokter'])->get();
        return view('rm.poli-umum', compact('kunjungan'));
    }

    public function editKunjungan(Request $request, $id)
    {
        $kunjungan = KunjunganPoliUmum::findOrFail($id);
        $kunjungan->update($request->only(['tanggal_kunjungan', 'jenis_pasien', 'diagnosis', 'pembiayaan', 'dokter_id']));

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil diupdate');
    }

    public function deleteKunjungan($id)
    {
        $kunjungan = KunjunganPoliUmum::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil dihapus');
    }

    public function rawatInap()
    {
        $pasien = Pasien::all();

        return view('rm.rawat-inap', [
            'pasien' => $pasien
        ]);
    }

    public function poliGigi()
    {
        return view('rm.poli-gigi');
    }
}
