<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KunjunganPoliGigi;
use App\Models\KunjunganPoliUmum;
use App\Models\KunjunganRawatInap;
use Illuminate\Http\Request;
use App\Models\Pasien;

class RmController extends Controller
{
    public function poliUmum()
    {
        $kunjungan = KunjunganPoliUmum::with(['pasien', 'dokter'])->get();
        $dokters = Dokter::all(); // Fetch doctors to avoid undefined variable error
        return view('rm.poli-umum', compact('kunjungan', 'dokters')); // Pass doctors to the view
    }

    public function editKunjunganumum(Request $request, $id)
    {
        $kunjungan = KunjunganPoliUmum::findOrFail($id);
        $kunjungan->update($request->only(['tanggal_kunjungan', 'jenis_pasien', 'diagnosis', 'pembiayaan', 'dokter_id']));

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil diupdate');
    }

    public function deleteKunjunganumum($id)
    {
        $kunjungan = KunjunganPoliUmum::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil dihapus');
    }

    public function rawatInap()
    {
        $kunjungan = KunjunganRawatInap::with(['pasien', 'dokterUgd', 'dokterRawatInap'])->get();
        $dokters = Dokter::all();
        return view('rm.rawat-inap', compact('kunjungan', 'dokters'));
    }

    public function editKunjunganinap(Request $request, $id)
    {
        $kunjungan = KunjunganRawatInap::findOrFail($id);
        $kunjungan->update($request->only(['tanggal_masuk', 'tanggal_keluar', 'jenis_pasien', 'diagnosis', 'pembiayaan', 'dokter_ugd_id', 'dokter_rawat_inap']));

        return redirect()->route('rawat-inap')->with('success', 'Data kunjungan berhasil diupdate');
    }

    public function deleteKunjunganinap($id)
    {
        $kunjungan = KunjunganRawatInap::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('rawat-inap')->with('success', 'Data kunjungan berhasil dihapus');
    }

    public function poliGigi()
    {
        $kunjungan = KunjunganPoliGigi::with(['pasien', 'dokter'])->get();
        return view('rm.poli-gigi', compact('kunjungan'));
    }

    public function editKunjungangigi(Request $request, $id)
    {
        $kunjungan = KunjunganPoliGigi::findOrFail($id);
        $kunjungan->update($request->only(['tanggal_kunjungan', 'jenis_pasien', 'diagnosis', 'pembiayaan', 'dokter_id']));

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil diupdate');
    }

    public function deleteKunjungangigi($id)
    {
        $kunjungan = KunjunganPoliGigi::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('poli-umum')->with('success', 'Data kunjungan berhasil dihapus');
    }
}
